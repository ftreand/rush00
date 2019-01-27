<?php

include("../Model/User.php");

function htmldump($variable, $height = "300px")
{
    echo "<pre style=\"border: 1px solid #000; height: {$height}; overflow: auto; margin: 0.5em;\">";
    var_dump($variable);
    echo "</pre>\n";
}

function create_account($post)
{
    if (!empty($post['login']) && !empty($post['passwd1']) && !empty($post['passwd2'])) {
        $login = $post["login"];
        $password = $post["passwd1"];
        $confirmation = $post["passwd2"];

        if ($password == $confirmation) {
            if (!file_exists("../private"))
                mkdir("../private");
            if (!file_exists('../private/passwd'))
                file_put_contents("../private/passwd", null);
            $data = unserialize(file_get_contents("../private/passwd"));
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if ($value['login'] === $login) {
                        //Login is already taken
                        header("Location: ../View/create_account.php");
                        exit();
                    }
                }
                add_user($login, $password);
                $_SESSION["login"] = $login;
                if ($login === "ftreand") {
                    $_SESSION["admin"] = true;
                }
                header("Location: ../View");
                exit();
            } else {
                add_user($login, $password);
                $_SESSION["login"] = $login;
                if ($login === "ftreand") {
                    $_SESSION["admin"] = true;
                }
                header("Location: ../View");
                exit();
            }
        } else {
            //different password
            header("Location: ../View/create_account.php");
            exit();
        }
    } else {
        // Variable not set
        header("Location: ../View/create_account.php");
        exit();
    }
}

function authentification($post)
{
    if (isset($post['login']) && isset($post['passwd'])) {
        $login = $post['login'];
        $passwd = $_POST['passwd'];
        $data = unserialize(file_get_contents("../private/passwd"));
        $pw = hash('whirlpool', $passwd);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if ($value['login'] == $login && $value['passwd'] == $pw) {
                    $_SESSION["login"] = $login;
                    if ($login === "ftreand") {
                        $_SESSION["admin"] = true;
                    }
                    header("Location: ../View");
                    exit();
                }
            }
            foreach ($data as $key => $value) {
                if ($value['login'] == $login) {
                    if ($value['passwd'] != $pw) {
                        // password false
                        header("Location: ../View/login.php");
                        exit();
                    }
                }
            }
            //user doesnt exists
        }
        header("Location: ../View/login.php");
    }
}

function delete_account($post)
{
    ;
    if (isset($post['password']) && !empty($post['password'])) {
        $password = hash('whirlpool', $post['password']);
        $data = unserialize(file_get_contents("../private/passwd"));
        foreach ($data as $key => $value) {
            if ($value['login'] == $_SESSION['login'] && $value['passwd'] === $password) {
                unset($data[$key]);
                file_put_contents("../private/passwd", serialize($data));
                session_destroy();
                header("Location: ../View");
            }
        }
    }
}

function check_if_user_exists($name)
{
    $users = unserialize(file_get_contents('../private/passwd'));
    if (isset($users) && !empty($users)) {
        foreach ($users as $user) {
            if ($user["login"] === $name) {
                return (true);
            }
        }
    }
    return (false);
}

function add_user_from_admin($post)
{
    if (isset($post["name"]) && !empty($post["name"]) && isset($post["password"]) && !empty($post["password"])) {
        echo $post["name"] . "<br>" . $post["password"];
        if (check_if_user_exists($post["name"]) === false) {
            add_user($post["name"], $post["password"]);
        }
        else {
            //user already existst
        }
    }
}


