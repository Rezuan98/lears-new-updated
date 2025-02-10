<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

try {
    // Create an instance of ImageManager with the GD driver
    $manager = new ImageManager(new Driver());

    // Create a red canvas
    $img = $manager->create(200, 100, 'ff0000');
    
    // Save the image in the current directory
    $img->save('test_image.jpg');
    
    echo "Image created successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}