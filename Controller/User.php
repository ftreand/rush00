<?php

    include("../Model/User.php");

    function create_account($post) {
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
                            //Login is already
                            header("Location: ../View/create_account.php");
                            exit();
                        }
                    }
                    addUser($login, $password);
                    $_SESSION["login"] = $login;
                    header("Location: ../View");
                    exit();
                } else {
                    addUser($login, $password);
                    $_SESSION["login"] = $login;
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

    function authentification($post) {
        if (isset($post['login']) && isset($post['passwd'])) {
            $login = $post['login'];
            $passwd = $_POST['passwd'];
            $data = unserialize(file_get_contents("../private/passwd"));
            $pw = hash('whirlpool', $passwd);

            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if ($value['login'] == $login && $value['passwd'] == $pw) {
                        $_SESSION["login"] = $login;
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
                header("Location: ../View/login.php");
            }
        }
    }


