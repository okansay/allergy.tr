<?php
/**
 * GINA Asthma Step Advisor - Decision Engine
 * Based on GINA 2024 Global Strategy Report and 2025 updates
 */

header('Content-Type: application/json; charset=utf-8');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

// Load treatment options
$treatmentOptionsPath = __DIR__ . '/data/gina/treatment_options.json';
$treatmentOptionsData = json_decode(file_get_contents($treatmentOptionsPath), true);

if (!$treatmentOptionsData) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load treatment options']);
    exit;
}

/**
 * Determine age group based on age
 */
function determine_age_group($age) {
    if ($age <= 5) {
        return '0_5';
    } elseif ($age <= 11) {
        return '6_11';
    } else {
        return '12_plus';
    }
}

/**
 * Calculate control level based on GINA Box 2-2 / Box 11-1
 */
function calculate_control_level($input) {
    $daytime = intval($input['daytime_symptoms_per_week'] ?? 0);
    $night = intval($input['night_waking_per_week'] ?? 0);
    $reliever = intval($input['reliever_use_days_per_week'] ?? 0);
    $activity = $input['activity_limitation'] ?? 'none';
    $reliever_type = $input['reliever_type'] ?? 'saba';

    $positive_criteria = 0;

    // Q1: Daytime symptoms > 2 per week
    if ($daytime > 2) {
        $positive_criteria++;
    }

    // Q2: Night waking > 0 per week
    if ($night > 0) {
        $positive_criteria++;
    }

    // Q3: Reliever use > 2 per week (only for SABA)
    if ($reliever > 2 && $reliever_type === 'saba') {
        $positive_criteria++;
    }

    // Q4: Activity limitation
    if ($activity !== 'none') {
        $positive_criteria++;
    }

    if ($positive_criteria == 0) {
        return 'well_controlled';
    } elseif ($positive_criteria <= 2) {
        return 'partly_controlled';
    } else {
        return 'uncontrolled';
    }
}

/**
 * Calculate future risk based on GINA risk factors
 */
function calculate_future_risk($input) {
    $high_risk_flags = 0;

    $ocs_exacerbations = intval($input['ocs_exacerbations_last_12m'] ?? 0);
    $hospitalizations = intval($input['hospitalizations_last_12m'] ?? 0);
    $icu_admission = boolval($input['icu_admission_ever'] ?? false);
    $current_smoker = $input['current_smoker'] ?? 'never';
    $fev1 = floatval($input['fev1_percent_predicted'] ?? 0);
    $saba_overuse = boolval($input['saba_overuse_suspected'] ?? false);

    if ($ocs_exacerbations >= 2) {
        $high_risk_flags++;
    }

    if ($hospitalizations >= 1 || $icu_admission) {
        $high_risk_flags++;
    }

    if ($fev1 > 0 && $fev1 < 60) {
        $high_risk_flags++;
    }

    if ($saba_overuse) {
        $high_risk_flags++;
    }

    if ($current_smoker === 'current') {
        $high_risk_flags++;
    }

    return $high_risk_flags == 0 ? 'low_risk' : 'high_risk';
}

/**
 * Infer current step from controller regimen
 */
function infer_current_step($input, $age_group) {
    $regimen_type = $input['controller_regimen_type'] ?? 'none';
    $ics_dose = $input['controller_ics_dose_category'] ?? 'not_applicable';

    // Simplified step inference
    if ($regimen_type === 'none') {
        return 1;
    }

    if ($regimen_type === 'ics_monotherapy' || $regimen_type === 'ltra') {
        return $ics_dose === 'low' ? 2 : 3;
    }

    if ($regimen_type === 'ics_laba_formoterol' || $regimen_type === 'ics_laba_nonformoterol') {
        if ($ics_dose === 'low') {
            return 3;
        } elseif ($ics_dose === 'medium') {
            return 4;
        } else {
            return 5;
        }
    }

    if ($regimen_type === 'biologic_addon' || $regimen_type === 'maintenance_ocs') {
        return 5;
    }

    return 2; // Default
}

/**
 * Decide step change based on scenario, control, risk, and current step
 */
function decide_step_change($scenario, $control_level, $future_risk, $current_step, $months_on_step, $weeks_since_exacerbation = null) {
    $step_change = 'no_change';
    $target_step = $current_step;

    if ($scenario === 'initial') {
        // Initial treatment: start at appropriate step
        if ($control_level === 'uncontrolled' || $future_risk === 'high_risk') {
            $target_step = 2;
        } else {
            $target_step = 1;
        }
        $step_change = 'initial';
    } elseif ($scenario === 'step_adjustment') {
        // Step adjustment logic
        if ($control_level === 'well_controlled' && $future_risk === 'low_risk' && $months_on_step >= 3) {
            // Consider step down
            $step_change = 'step_down';
            $target_step = max(1, $current_step - 1);
        } elseif ($control_level === 'uncontrolled' || $future_risk === 'high_risk') {
            // Step up
            $step_change = 'step_up';
            $target_step = min(5, $current_step + 1);
        } else {
            // No change
            $step_change = 'no_change';
            $target_step = $current_step;
        }
    } elseif ($scenario === 'post_exacerbation') {
        // Post-exacerbation logic
        if ($weeks_since_exacerbation !== null && $weeks_since_exacerbation < 4) {
            $step_change = 'acute_period';
            $target_step = $current_step;
        } elseif ($control_level === 'uncontrolled' || $future_risk === 'high_risk') {
            $step_change = 'step_up';
            $target_step = min(5, $current_step + 1);
        } else {
            // Maintain current step after severe exacerbation
            $step_change = 'maintain';
            $target_step = $current_step;
        }
    }

    return [
        'step_change' => $step_change,
        'target_step' => $target_step
    ];
}

/**
 * Estimate severity based on step and control
 */
function estimate_severity($age_group, $step, $control_level, $future_risk) {
    if ($step <= 2 && ($control_level === 'well_controlled' || $control_level === 'partly_controlled')) {
        return 'mild';
    } elseif ($step >= 3 && $step <= 4) {
        return 'moderate';
    } elseif ($step >= 4 && ($future_risk === 'high_risk' || $control_level === 'uncontrolled')) {
        return 'severe';
    }

    return 'moderate';
}

/**
 * Select treatment options for target step
 */
function select_track_options($age_group, $target_step, $weight_kg, $treatment_data) {
    $track_1_option = null;
    $track_2_option = null;

    foreach ($treatment_data['treatment_options'] as $option) {
        if ($option['age_group'] === $age_group && $option['step'] == $target_step) {
            if ($option['track'] === 'track_1' && !$track_1_option) {
                $track_1_option = $option;
            } elseif ($option['track'] === 'track_2' && !$track_2_option) {
                $track_2_option = $option;
            }
        }
    }

    return [
        'track_1_option' => $track_1_option,
        'track_2_option' => $track_2_option
    ];
}

/**
 * Detect severe asthma flag
 */
function detect_severe_asthma($age_group, $current_step, $control_level, $future_risk, $months_on_step) {
    if ($current_step >= 4 && $control_level !== 'well_controlled' && $future_risk === 'high_risk') {
        return true;
    }

    if ($current_step >= 4 && $months_on_step >= 3 && $control_level === 'uncontrolled') {
        return true;
    }

    return false;
}

/**
 * Build device recommendation
 */
function build_device_recommendation($age_group, $input) {
    if ($age_group === '0_5') {
        return 'pMDI_with_spacer_and_mask';
    }

    if ($age_group === '6_11') {
        $coordination = $input['inhaler_coordination'] ?? 'good';
        return $coordination === 'good' ? 'DPI_or_pMDI_with_spacer' : 'pMDI_with_spacer';
    }

    return 'DPI_or_pMDI';
}

// ============================================================================
// Main Processing
// ============================================================================

try {
    // Extract input data
    $age = intval($input['age'] ?? 0);
    $weight_kg = floatval($input['weight_kg'] ?? 0);
    $scenario = $input['scenario'] ?? 'initial';

    if ($age === 0 || $weight_kg === 0) {
        throw new Exception('Age and weight are required');
    }

    // Determine age group
    $age_group = determine_age_group($age);

    // Calculate control level
    $control_level = calculate_control_level($input);

    // Calculate future risk
    $future_risk = calculate_future_risk($input);

    // Infer current step (for step_adjustment and post_exacerbation)
    $current_step = 1;
    if ($scenario === 'step_adjustment' || $scenario === 'post_exacerbation') {
        $current_step = infer_current_step($input, $age_group);
    }

    // Decide step change
    $months_on_step = intval($input['months_on_current_step'] ?? 0);
    $weeks_since_exacerbation = isset($input['weeks_since_last_exacerbation']) ? intval($input['weeks_since_last_exacerbation']) : null;

    $step_decision = decide_step_change($scenario, $control_level, $future_risk, $current_step, $months_on_step, $weeks_since_exacerbation);
    $target_step = $step_decision['target_step'];
    $step_change = $step_decision['step_change'];

    // Estimate severity
    $estimated_severity = estimate_severity($age_group, $target_step, $control_level, $future_risk);

    // Select track options
    $track_options = select_track_options($age_group, $target_step, $weight_kg, $treatmentOptionsData);

    // Detect severe asthma
    $severe_asthma_flag = detect_severe_asthma($age_group, $current_step, $control_level, $future_risk, $months_on_step);

    // Device recommendation
    $device_recommendation = build_device_recommendation($age_group, $input);

    // Build output
    $output = [
        'success' => true,
        'age_group' => $age_group,
        'control_level' => $control_level,
        'future_risk' => $future_risk,
        'estimated_severity' => $estimated_severity,
        'current_step' => $current_step,
        'recommended_step_change' => $step_change,
        'target_step' => $target_step,
        'track_1_option' => $track_options['track_1_option'],
        'track_2_option' => $track_options['track_2_option'],
        'severe_asthma_flag' => $severe_asthma_flag,
        'severe_asthma_comment' => $severe_asthma_flag
            ? 'Persistent uncontrolled symptoms and high risk on Step 4 or above – evaluate for difficult-to-treat/severe asthma and consider referral.'
            : null,
        'device_recommendation' => $device_recommendation,
        'safety_disclaimer' => 'Bu sistem klinik karar desteğidir, nihai karar hekimindir. Öneriler GINA 2024–2025 rehberleri temel alınarak oluşturulmuştur.'
    ];

    echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
