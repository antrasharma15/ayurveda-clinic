<?php
// SMTP Configuration
define('SMTP_HOST', 'smtp.gmail.com'); // Change to your SMTP host
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com'); // Your email
define('SMTP_PASSWORD', 'your-app-password'); // App password for Gmail
define('SMTP_FROM', 'your-email@gmail.com');

// Twilio Configuration for WhatsApp
define('TWILIO_SID', 'your-twilio-sid'); // Get from Twilio Console
define('TWILIO_TOKEN', 'your-twilio-token'); // Get from Twilio Console
define('TWILIO_FROM', 'whatsapp:+14155238886'); // Twilio WhatsApp number
?>