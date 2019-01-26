<?php
session_start();
function create($s1, $s2){
    $data = unserialize(file_get_contents('../private/passwd'));
    $new['login'] = $s1;
    $new['passwd'] = hash('whirlpool', $s2);
    $data[] = $new;
    file_put_contents("../private/passwd", serialize($data));
    echo "OK\n";
}

var_dump($_POST);
if (!empty($_POST['login']) && !empty($_POST['passwd1']) && !empty($_POST['passwd2']))
{
if ($_POST['passwd1'] == $_POST['passwd2']){
    if (!file_exists("../private"))
        mkdir("../private");
    if (!file_exists('../private/passwd'))
        file_put_contents("../private/passwd", null);
    $data = unserialize(file_get_contents("../private/passwd"));
    if (!empty($data))
    {
        foreach ($data as $key => $value)
        {
            if ($value['login'] === $_POST['login']){
                echo "User already exists\n";
                exit();
            }
        }
        create($_POST['login'], $_POST['passwd1']);
    }
    else
        create($_POST['login'], $_POST['passwd1']);
}
else
echo "Mot de passe differents\n";
}
else
    echo "ERROR\n";
?>