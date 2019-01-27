<?php

function add_category($name)
{
    $data = unserialize(file_get_contents('../private/categories'));
    $new['name'] = $name;
    $data[] = $new;

    foreach ($data as $category) {
        print_r($category);
    }

    file_put_contents("../private/categories", serialize($data));
}