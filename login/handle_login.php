<?php
session_start();
function auth($login, $passwd)
{
    $data = unserialize(file_get_contents("../private/passwd"));
    $pw = hash('whirlpool', $passwd);
    foreach($data as $key => $value){
        if ($value['login'] == $login && $value['passwd'] == $pw)
            return 1;
    }
    foreach($data as $key => $value){
        if ($value['login'] == $login){
            if ($value['passwd'] != $pw)
                return 3;
        }
    }
    return 2;
}

if (isset($_POST['login']) && isset($_POST['passwd'])){
    if (auth($_POST['login'], $_POST['passwd']) == 1){
        $_SESSION['loggued_on_user'] = $_POST['login'];
        echo "LOGGED\n";
    }
    elseif (auth($_POST['login'], $_POST['passwd']) == 2){
        $_SESSION['loggued_on_user'] = $_POST['login'];
        echo "LOGIN DOES NOT EXIST\n";
    }
    else{
        $_SESSION['loggued_on_user'] = $_POST['login'];
        echo "PASSWORD ERROR\n";
    }
}
?>