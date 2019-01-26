<?php

    function add_article($name, $price, $path) {
        $data = unserialize(file_get_contents('../private/article'));
        $new['name'] = $name;
        $new['price'] = $price;
        $new['path'] = $path;
        $data[] = $new;
        file_put_contents("../private/article", serialize($data));
    }

