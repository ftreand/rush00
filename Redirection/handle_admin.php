<?php
    session_start();
    include("../Controller/User.php");
    include("../Controller/ArticleController.php");

    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        if ($_GET["action"] === "add_article") {
            create_article($_POST, $_FILES);
        }
        else if ($_GET["action"] === "modify_article") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "delete_article") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "add_categorie") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "modify_categorie") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "delete_categorie") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "add_user") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "modify_user") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "delete_user") {
            echo $_GET["action"];
        }
        else {
            //action unknown
        }
    }
    else {
        //not admin
    }