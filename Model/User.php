<?php

function addUser($user, $password) {
    $data = unserialize(file_get_contents('../private/passwd'));
    $new['login'] = $user;
    $new['passwd'] = hash('whirlpool', $password);
    $data[] = $new;
    file_put_contents("../private/passwd", serialize($data));
}