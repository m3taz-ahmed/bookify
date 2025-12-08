<?php
// Simple test file to check if server can access admin path
echo "TEST FILE WORKING!\n";
echo "Current URL: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "PHP Self: " . $_SERVER['PHP_SELF'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
