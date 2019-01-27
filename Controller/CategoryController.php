<?php

include("../Model/Category.php");

function check_if_category_exists($name)
{
    $data = unserialize(file_get_contents("../private/categories"));
    if (isset($data) && !empty($data)) {
        if (isset($data[$name])) {
            return (true);
        }
    }
    return (false);
}

function create_category($name)
{
    if (!empty($name)) {
        if (check_if_category_exists($name) === false) {
            add_category($name);
            echo "categories doesnt exist";
        }
        else {
            echo "categories exists";
        }
    }
}

