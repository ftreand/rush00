<?php

function add_category($name)
{
    $data = unserialize(file_get_contents('../private/categories'));
    $data[$name] = [];
    file_put_contents("../private/categories", serialize($data));
}