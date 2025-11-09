<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skin Test Module - Debug Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        .log-item { padding: 8px; margin: 4px 0; border-radius: 4px; font-family: monospace; font-size: 12px; }
        .log-success { background: #d1fae5; color: #065f46; }
        .log-error { background: #fee2e2; color: #991b1b; }
        .log-info { background: #dbeafe; color: #1e40af; }
        .log-warning { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-4">
            <h1 class="text-2xl font-bold mb-4">🧪 Skin Test Module - Debug Test</h1>

            <!-- Debug Log -->
            <div class="mb-6">
                <h2 class="text-lg font-bold mb-2">📋 Debug Log:</h2>
                <div id="debugLog" class="bg-gray-50 rounded-lg p-4 max-h-96 overflow-y-auto">
                    <div class="log-item log-info">🔄 Initializing test...</div>
                </div>
            </div>

            <!-- Test Results -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Data.js Status</div>
                    <div id="dataStatus" class="text-2xl font-bold">⏳</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">UI.js Status</div>
                    <div id="uiStatus" class="text-2xl font-bold">⏳</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Total Drugs</div>
                    <div id="drugCount" class="text-2xl font-bold">0</div>
                </div>
            </div>

            <!-- Actual Module Test -->
            <div class="border-t pt-6">
                <h2 class="text-xl font-bold mb-4">🎯 Module Test</h2>

                <!-- Dropdown Test -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Dropdown Test:</label>
                    <select id="drugDropdown" class="w-full p-3 border rounded-lg">
                        <option value="">Loading...</option>
                    </select>
                    <div id="dropdownStatus" class="text-sm mt-2"></div>
                </div>

                <!-- Search Test -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Search Test:</label>
                    <input
                        type="text"
                        id="drugSearch"
                        placeholder="Type 3+ characters..."
                        class="w-full p-3 border rounded-lg"
                    />
                    <div id="searchResults" class="mt-2"></div>
                </div>

                <!-- Drug Details -->
                <div id="drugDetails" class="mt-4"></div>
            </div>
        </div>
    </div>

    <script>
        // Custom logging
        const debugLog = document.getElementById('debugLog');
        function log(message, type = 'info') {
            const colors = {
                success: 'log-success',
                error: 'log-error',
                info: 'log-info',
                warning: 'log-warning'
            };
            const div = document.createElement('div');
            div.className = `log-item ${colors[type]}`;
            div.textContent = message;
            debugLog.appendChild(div);
            debugLog.scrollTop = debugLog.scrollHeight;
            console.log(message);
        }

        // Override console
        const originalLog = console.log;
        const originalError = console.error;
        console.log = function(...args) {
            log(args.join(' '), 'info');
            originalLog.apply(console, args);
        };
        console.error = function(...args) {
            log(args.join(' '), 'error');
            originalError.apply(console, args);
        };

        // Status updaters
        function updateStatus(id, status, color) {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = status;
                el.style.color = color;
            }
        }

        // Load scripts
        log('🔄 Starting script load...', 'info');

        // Load data.js
        const dataScript = document.createElement('script');
        dataScript.src = '/modules/js/skintest/data.js';

        dataScript.onload = function() {
            log('✅ data.js loaded successfully', 'success');
            updateStatus('dataStatus', '✅ Loaded', 'green');

            // Check allDrugs
            if (typeof allDrugs !== 'undefined') {
                log(`✅ allDrugs available with ${allDrugs.length} drugs`, 'success');
                updateStatus('drugCount', allDrugs.length, 'green');

                // Show some drugs
                log(`📝 Sample drugs: ${allDrugs.slice(0, 3).map(d => d.name).join(', ')}`, 'info');
            } else {
                log('❌ allDrugs is undefined!', 'error');
                updateStatus('drugCount', '❌ Error', 'red');
            }

            // Load ui.js
            const uiScript = document.createElement('script');
            uiScript.src = '/modules/js/skintest/ui.js';

            uiScript.onload = function() {
                log('✅ ui.js loaded successfully', 'success');
                updateStatus('uiStatus', '✅ Loaded', 'green');

                // Test initialization
                setTimeout(() => {
                    testModuleFunctions();
                }, 500);
            };

            uiScript.onerror = function(e) {
                log('❌ Failed to load ui.js: ' + e, 'error');
                updateStatus('uiStatus', '❌ Failed', 'red');
            };

            document.head.appendChild(uiScript);
        };

        dataScript.onerror = function(e) {
            log('❌ Failed to load data.js: ' + e, 'error');
            updateStatus('dataStatus', '❌ Failed', 'red');
        };

        document.head.appendChild(dataScript);

        // Test module functions
        function testModuleFunctions() {
            log('🧪 Testing module functions...', 'info');

            // Check dropdown
            const dropdown = document.getElementById('drugDropdown');
            if (dropdown) {
                const optionCount = dropdown.options.length;
                log(`📊 Dropdown has ${optionCount} options`, optionCount > 1 ? 'success' : 'warning');
                document.getElementById('dropdownStatus').innerHTML =
                    `<span class="text-sm ${optionCount > 1 ? 'text-green-600' : 'text-red-600'}">
                        ${optionCount > 1 ? '✅ Populated with ' + optionCount + ' options' : '❌ Empty or not populated'}
                    </span>`;
            } else {
                log('❌ Dropdown element not found', 'error');
            }

            // Check search
            const searchInput = document.getElementById('drugSearch');
            if (searchInput) {
                log('✅ Search input found', 'success');
            } else {
                log('❌ Search input not found', 'error');
            }

            // Check if functions exist
            const functions = ['initSkinTestModule', 'populateDropdown', 'performSearch'];
            functions.forEach(fn => {
                if (typeof window[fn] === 'function') {
                    log(`✅ Function ${fn} exists`, 'success');
                } else {
                    log(`❌ Function ${fn} not found`, 'error');
                }
            });

            log('✅ Test complete!', 'success');
        }

        // Manual test button
        setTimeout(() => {
            const testBtn = document.createElement('button');
            testBtn.textContent = '🔄 Re-run Tests';
            testBtn.className = 'mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg';
            testBtn.onclick = testModuleFunctions;
            document.querySelector('.border-t').appendChild(testBtn);
        }, 2000);
    </script>
</body>
</html>
