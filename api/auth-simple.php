<?php
// Super minimal auth - just to test if endpoint works
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => true,
    'message' => 'Simple auth endpoint works!',
    'test' => 'If you see this, the endpoint is accessible'
]);
exit;
