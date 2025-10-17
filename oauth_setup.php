<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName('Ayurveda Clinic');
$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
$client->setAuthConfig('credentials.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');

if (isset($_GET['code'])) {
    $authCode = $_GET['code'];
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    file_put_contents('token.json', json_encode($accessToken));
    echo "OAuth setup complete. Token saved.";
    exit();
}

if (file_exists('token.json')) {
    $accessToken = json_decode(file_get_contents('token.json'), true);
    $client->setAccessToken($accessToken);
}

if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents('token.json', json_encode($client->getAccessToken()));
        echo "Token refreshed.";
    } else {
        $authUrl = $client->createAuthUrl();
        echo "<a href='$authUrl'>Click here to authorize</a>";
        echo "<br>After authorization, copy the code and paste it below:<br>";
        echo "<form method='GET'>";
        echo "<input type='text' name='code' placeholder='Authorization Code'>";
        echo "<button type='submit'>Submit</button>";
        echo "</form>";
    }
} else {
    echo "OAuth is already set up.";
}
?>