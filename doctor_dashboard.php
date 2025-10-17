<?php
session_start();
if (!isset($_SESSION['doctor_id'])) {
    header('Location: doctor_login.php');
    exit();
}
include 'db.php';
include 'config.php';
require_once 'vendor/autoload.php';
$doctor_id = $_SESSION['doctor_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];
    $assigned_time = $_POST['assigned_time'];

    // Create Google Calendar event and get Meet link
    $meet_link = createGoogleMeetEvent($assigned_time, $appointment_id);

    $sql = "UPDATE appointments SET status='confirmed', assigned_time='$assigned_time', meet_link='$meet_link' WHERE id=$appointment_id";
    $conn->query($sql);

    // Get appointment and doctor details
    $appt_sql = "SELECT a.*, d.email as doctor_email, d.phone as doctor_phone FROM appointments a JOIN doctors d ON a.doctor_id = d.id WHERE a.id=$appointment_id";
    $appt_result = $conn->query($appt_sql);
    $appt = $appt_result->fetch_assoc();

    // Send notifications to user and doctor
    sendNotification($appt['email'], $appt['phone'], $assigned_time, $meet_link, $_SESSION['doctor_name'], 'user');
    sendNotification($appt['doctor_email'], $appt['doctor_phone'], $assigned_time, $meet_link, $_SESSION['doctor_name'], 'doctor');
}

$sql = "SELECT * FROM appointments WHERE doctor_id=$doctor_id AND status='pending'";
$result = $conn->query($sql);
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

function createGoogleMeetEvent($time, $appt_id) {
    $client = new Google_Client();
    $client->setApplicationName('Ayurveda Clinic');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');

    // If token exists, set it
    if (file_exists('token.json')) {
        $accessToken = json_decode(file_get_contents('token.json'), true);
        $client->setAccessToken($accessToken);
    }

    // If token is expired, refresh it
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // For first time, need to authorize manually
            $authUrl = $client->createAuthUrl();
            echo "Open this URL in browser: $authUrl\n";
            $authCode = trim(fgets(STDIN));
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            file_put_contents('token.json', json_encode($accessToken));
        }
        file_put_contents('token.json', json_encode($client->getAccessToken()));
    }

    $service = new Google_Service_Calendar($client);

    $event = new Google_Service_Calendar_Event([
        'summary' => 'Ayurveda Consultation',
        'description' => 'Appointment ID: ' . $appt_id,
        'start' => [
            'dateTime' => $time,
            'timeZone' => 'Asia/Kolkata',
        ],
        'end' => [
            'dateTime' => date('Y-m-d\TH:i:s', strtotime($time . ' +1 hour')),
            'timeZone' => 'Asia/Kolkata',
        ],
        'conferenceData' => [
            'createRequest' => [
                'requestId' => uniqid(),
                'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
            ],
        ],
    ]);

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

    return $event->hangoutLink;
}

function sendNotification($email, $phone, $time, $meet_link, $doctor_name, $recipient) {
    $subject = "Appointment Confirmed";
    if ($recipient == 'user') {
        $message = "Your appointment with Dr. $doctor_name is confirmed for $time. Meet link: $meet_link";
    } else {
        $message = "Appointment confirmed for $time. Meet link: $meet_link";
    }

    // Send email via SMTP
    sendEmail($email, $subject, $message);

    // Send WhatsApp via Twilio
    sendWhatsApp($phone, $message);
}

function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = SMTP_PORT;

    $mail->setFrom(SMTP_FROM, 'Ayurveda Clinic');
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}

function sendWhatsApp($to, $message) {
    $twilio = new Twilio\Rest\Client(TWILIO_SID, TWILIO_TOKEN);
    try {
        $twilio->messages->create(
            "whatsapp:$to",
            [
                "from" => TWILIO_FROM,
                "body" => $message
            ]
        );
    } catch (Exception $e) {
        // Log error
        file_put_contents('error_log.txt', $e->getMessage() . "\n", FILE_APPEND);
    }
}
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, Dr. <?php echo $_SESSION['doctor_name']; ?></h1>
        <a href="doctor_logout.php">Logout</a>

        <h2>Pending Appointments</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Symptoms</th>
                <th>Preferred Date</th>
                <th>Action</th>
            </tr>
            <?php foreach ($appointments as $appt) { ?>
                <tr>
                    <td><?php echo $appt['name']; ?></td>
                    <td><?php echo $appt['email']; ?></td>
                    <td><?php echo $appt['phone']; ?></td>
                    <td><?php echo $appt['symptoms']; ?></td>
                    <td><?php echo $appt['preferred_date']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="appointment_id" value="<?php echo $appt['id']; ?>">
                            <input type="datetime-local" name="assigned_time" required>
                            <button type="submit">Confirm</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>