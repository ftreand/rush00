<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<body>
        <div class="loginbox">
        <div class="user"><i class="fas fa-user icon"></i></div>
                <h1>Create Account<h1>
                <form action="handle_account.php" method="POST">
                        <p>Username</p>
                        <input type="text" name="login" placeholder="Enter Username">
                        <p>Password</p>
                        <input type="password" name="passwd1" placeholder="Enter Password">
                        <p>Password Confirmation</p>
                        <input type="password" name="passwd2" placeholder="Enter Password">
                        <input type="submit" name="" value="Login"><br>
                </form>

        </div>

</body>
</head>
</html>