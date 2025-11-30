<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$target_dir = "../uploads/products/";
echo "Target Dir: " . $target_dir . "\n";
echo "Absolute Path: " . realpath("../uploads") . "/products/\n";

if (!file_exists($target_dir)) {
    echo "Directory does not exist. Attempting to create...\n";
    if (mkdir($target_dir, 0777, true)) {
        echo "Directory created successfully.\n";
    } else {
        echo "Failed to create directory. Last error: " . print_r(error_get_last(), true) . "\n";
    }
} else {
    echo "Directory already exists.\n";
}

$test_file = $target_dir . "test.txt";
if (file_put_contents($test_file, "test content")) {
    echo "File write successful.\n";
    unlink($test_file);
} else {
    echo "File write failed.\n";
}

echo "Current User: " . get_current_user() . "\n";
echo "Effective User ID: " . posix_geteuid() . "\n";
?>
