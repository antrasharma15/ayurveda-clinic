<?php
// Create demo images for the slider
function createDemoImage($width, $height, $text, $filename) {
    $image = imagecreate($width, $height);
    
    // Colors
    $bg_color = imagecolorallocate($image, 60, 120, 60); // Green
    $text_color = imagecolorallocate($image, 255, 255, 255); // White
    
    // Fill background
    imagefill($image, 0, 0, $bg_color);
    
    // Add text
    $font_size = 5;
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);
    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;
    
    imagestring($image, $font_size, $x, $y, $text, $text_color);
    
    // Save image
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
}

// Create demo images directory
if (!file_exists('images')) {
    mkdir('images', 0777, true);
}

// Create 5 demo images
createDemoImage(1200, 400, 'Ayurvedic Panchakarma Treatments', 'images/slide1.jpg');
createDemoImage(1200, 400, 'Traditional Herbal Medicine', 'images/slide2.jpg');
createDemoImage(1200, 400, 'Holistic Wellness Programs', 'images/slide3.jpg');
createDemoImage(1200, 400, 'Mind-Body Healing Therapies', 'images/slide4.jpg');
createDemoImage(1200, 400, 'Expert Ayurvedic Practitioners', 'images/slide5.jpg');

echo "Demo images created successfully!";
?>