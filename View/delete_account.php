<?php
include("header.php");
?>

<body>
        <div class="loginbox">
        <div class="user"><i class="fas fa-user icon"></i></div>
                <h1>Delete Account<h1>
                <?php 
                    echo $_SESSION['login'];
                ?>
                <form action="../Redirection/delete_account.php" method="POST">
                        <p>Password Confirmation</p>
                        <input type="password" name="password" placeholder="Enter Password">
                        <input type="submit" name="" value="Login"><br>
                </form>

        </div>

</body>
</head>
</html>