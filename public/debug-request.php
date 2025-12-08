<?php
// Debug file - place in public folder
file_put_contents(__DIR__ . '/debug.log', date('Y-m-d H:i:s') . " - Request received\n", FILE_APPEND);
file_put_contents(__DIR__ . '/debug.log', "URL: " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/debug.log', "Script: " . $_SERVER['SCRIPT_NAME'] . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/debug.log', "Path: " . $_SERVER['PATH_INFO'] ?? 'N/A' . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/debug.log', "Query: " . $_SERVER['QUERY_STRING'] ?? 'N/A' . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/debug.log', "---\n", FILE_APPEND);

echo "Debug logged! Check public/debug.log";
