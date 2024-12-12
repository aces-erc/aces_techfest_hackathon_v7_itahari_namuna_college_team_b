<?php
session_start();

// Generate random code
$captcha_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
$_SESSION['captcha'] = $captcha_code;

// Create the CAPTCHA image
$width = 120;
$height = 40;
$image = imagecreatetruecolor($width, $height);

// Colors
$background_color = imagecolorallocate($image, 0, 0, 0); // Black background
$text_color = imagecolorallocate($image, 255, 255, 255); // White text

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $background_color);

// Add random dots and lines to prevent automated reading
for ($i = 0; $i < 100; $i++) {
    $dot_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($image, rand(0, $width), rand(0, $height), $dot_color);
}

// Add CAPTCHA text
$font_path = __DIR__ . '/Inter-Regular.ttf';
if (!file_exists($font_path)) {
    die('Font file not found. Please ensure Inter-Regular.ttf is in the correct location.');
}
imagettftext($image, 20, 0, 15, 30, $text_color, $font_path, $captcha_code);

// Output the image as PNG
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>
