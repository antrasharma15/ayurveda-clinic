<?php
require 'vendor/autoload.php';
require 'config.php';

use Twilio\Rest\Client;

$to = $_GET['to'] ?? null; // expected: whatsapp:+919876543210
$body = $_GET['body'] ?? 'Test WhatsApp message from Ayurveda Clinic';

if (!$to) {
    echo "Provide recipient in `to` query param, e.g. ?to=whatsapp:+919876543210";
    exit;
}

try {
    $client = new Client(TWILIO_SID, TWILIO_TOKEN);
    $message = $client->messages->create(
        $to,
        [
            'from' => TWILIO_FROM,
            'body' => $body
        ]
    );

    echo "WhatsApp message sent. SID: " . $message->sid;
} catch (Exception $e) {
    echo "WhatsApp send failed: " . $e->getMessage();
}
?>