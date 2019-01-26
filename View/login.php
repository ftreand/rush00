<?php
include("header.php");
if (isset($_SESSION["login"])) {
    header("Location: ./index.php");
}
?>

<body>
        <div class="loginbox">
            <div class="user"><i class="fas fa-user icon"></i></div>
                <h1>Login Here<h1>
                <form action="../Redirection/login.php" method="POST">
                        <p>Username</p>
                        <input type="text" name="login" placeholder="Enter Username">
                        <p>Password</p>
                        <input type="password" name="passwd" placeholder="Enter Password">
                        <input type="submit" name="" value="Login"><br>
                        <a href="create_account.php">Create an account</a>
                </form>

        </div>

</body>
</head>
</html>