<?php
include("header.php");
?>

<body>
        <div class="loginbox">
        <div class="user"><i class="fas fa-user icon"></i></div>
                <h1>Create Account<h1>
                <form action="../Redirection/create_acount.php" method="POST">
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