<?php
include("./inc/config.php");
include('./inc/functions.php');

$userClass = new userClass();
$ga = new GoogleAuthenticator();
$secret = $ga->createSecret();

$errorMsgReg = '';
$errorMsgLogin = '';

if (!empty($_SESSION['uid'])) {
    header("Location: device_confirmations.php");
    exit;
}

if (!empty($_POST['loginSubmit'])) {
    $usernameEmail = isset($_POST['usernameEmail']) ? $_POST['usernameEmail'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (strlen(trim($usernameEmail)) > 1 && strlen(trim($password)) > 1) {
        $uid = $userClass->userLogin($usernameEmail, $password, $secret);
        if ($uid) {
            header("Location: device_confirmations.php");
            exit;
        } else {
            $errorMsgLogin = "Please check login details.";
        }
    }
}

if (!empty($_POST['signupSubmit'])) {
    $username = isset($_POST['usernameReg']) ? $_POST['usernameReg'] : '';
    $email = isset($_POST['emailReg']) ? $_POST['emailReg'] : '';
    $password = isset($_POST['passwordReg']) ? $_POST['passwordReg'] : '';
    $name = isset($_POST['nameReg']) ? $_POST['nameReg'] : '';

    $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
    $email_check = filter_var($email, FILTER_VALIDATE_EMAIL);
    $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

    if ($username_check && $email_check && $password_check && strlen(trim($name)) > 0) {
        $uid = $userClass->userRegistration($username, $password, $email, $name, $secret);
        if ($uid) {
            header("Location: device_confirmations.php");
            exit;
        } else {
            $errorMsgReg = "Username or Email already exists.";
        }
    } else {
        $errorMsgReg = "Validation failed. Please check the following:";
        if (!$username_check) {
            $errorMsgReg .= " Username must be 3-20 characters and only contain letters, numbers, or underscores.";
        }
        if (!$email_check) {
            $errorMsgReg .= " Email is not valid.";
        }
        if (!$password_check) {
            $errorMsgReg .= " Password must be 6-20 characters and may include special characters.";
        }
        if (strlen(trim($name)) == 0) {
            $errorMsgReg .= " Name cannot be empty.";
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>2-Step Verification using Google Authenticator</title>
    <link rel="stylesheet" type="text/css" href="style.css" charset="utf-8" />
</head>

<body>
    <div id="container">
        <h1>2-Step Verification using Google Authenticator</h1>
        <div id="login">
            <h3>Login</h3>
            <form method="post" action="" name="login">
                <label>Username or Email</label>
                <input type="text" name="usernameEmail" autocomplete="off" />
                <label>Password</label>
                <input type="password" name="password" autocomplete="off" />
                <div class="errorMsg"><?= $errorMsgLogin ?></div>
                <input type="submit" class="button" name="loginSubmit" value="Login">
            </form>
        </div>

        <div id="signup">
            <h3>Registration</h3>
            <form method="post" action="" name="signup">
                <label>Name</label>
                <input type="text" name="nameReg" autocomplete="off" />
                <label>Email</label>
                <input type="text" name="emailReg" autocomplete="off" />
                <label>Username</label>
                <input type="text" name="usernameReg" autocomplete="off" />
                <label>Password</label>
                <input type="password" name="passwordReg" autocomplete="off" />
                <div class="errorMsg"><?= $errorMsgReg ?></div>
                <input type="submit" class="button" name="signupSubmit" value="Signup">
            </form>
        </div>
    </div>
</body>

</html>
