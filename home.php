<?php
include('./inc/config.php');
include('./inc/functions.php');

session_start();
if (!isset($_SESSION['uid'])) {
    header("Location: index.php"); 
    exit;
}

$userClass = new userClass();
$userDetails = $userClass->userDetails($_SESSION['uid']);

if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $secret = $userDetails->google_auth_code;
    
    $ga = new GoogleAuthenticator();
    $checkResult = $ga->verifyCode($secret, $code, 1); // 1 = 1*30sec clock tolerance

    if ($checkResult) {
        $_SESSION['googleCode'] = $code;
    } else {
        echo 'FAILED';
    }
}

include('session.php');
$userDetails = $userClass->userDetails($session_uid);
?>

<!DOCTYPE html>
<html>

<head>
    <title>2-Step Verification using Google Authenticator</title>
    <link rel="stylesheet" type="text/css" href="style.css" charset="utf-8" />
</head>

<body>
    <div id="container">
        <h1>Welcome <?php echo htmlspecialchars($userDetails->name); ?></h1>
        <pre>
            <?php print_r($userDetails); ?>
        </pre>
        <h4><a href="./logout.php">Logout</a></h4>
    </div>
</body>

</html>
