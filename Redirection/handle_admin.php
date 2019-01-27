<?php
    session_start();
    include("../Controller/User.php");
    include("../Controller/ArticleController.php");
    include("../Controller/CategoryController.php");

    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        if ($_GET["action"] === "add_article") {
            create_article($_POST, $_FILES);
        }
        else if ($_GET["action"] === "modify_article") {
            modify_article($_POST, $_FILES);
        }
        else if ($_GET["action"] === "delete_article") {
            delete_article($_POST);
        }
        else if ($_GET["action"] === "add_category") {
            create_category($_POST["name"]);
        }
        else if ($_GET["action"] === "modify_category") {
            modify_category($_POST);
        }
        else if ($_GET["action"] === "delete_category") {
            delete_category($_POST);
        }
        else if ($_GET["action"] === "add_user") {
            add_user_from_admin($_POST);
        }
        else if ($_GET["action"] === "modify_user") {
            echo $_GET["action"];
        }
        else if ($_GET["action"] === "delete_user") {
            echo $_GET["action"];
        }
        else {
            //action unknown
            header("Location: ../View");
        }
    }
    else {
        //not admin
    }