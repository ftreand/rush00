<?php
session_start();
?>
</<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

</head>
<body>
<header class="main_header">
    <nav>
        <ul>
            <li class="viande"><a href="index.php">Acceuil</a>
            </li>
            <li class="pdj"><a href="#">Catégories</a>
                <ul class="submenu">
                    <li><a href="#">Hauts</a></li>
                    <li><a href="#">Bas</a></li>
                    <li><a href="#">Accessoires</a></li>
                    <li><a href="#">Soldes</a></li>
                </ul>
            </li>
            <li class="poisson"><?php
            if (isset($_SESSION) && !empty($_SESSION))
                echo "<a href='delete_account.php'>Delete Account</a>";
            ?>
            </li>
            <li class="poisson"><?php
                if (isset($_SESSION) && !empty($_SESSION)) {
                    echo "<a href='../Redirection/disconnect.php'>Déconnexion</a>";
                }
                else
                    echo "<a href=\"login.php\">Identification</a>" ?>
                <ul class="submenu">
                </ul>
            </li>
            <?php
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
                echo "<li class=\"poisson\"><a href='admin.php'>Administration page</a></li>";
            }
            ?>
            <li class="vegan"><a href="#">Panier</a>
                <ul class="submenu">
                </ul>
            </li>
        </ul>
    </nav>
</header>