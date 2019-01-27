<?php

    include("../Model/Article.php");

    function check_if_exists($name) {
        $data = unserialize(file_get_contents("../private/articles"));
        if (isset($data) && !empty($data)) {
            foreach ($data as $article) {
                if ($article["name"] === $name) {
                    return (true);
                }
            }
        }
        return (false);
    }

    function get_categories($post) {
        $categories = [];
        foreach ($post as $key => $value) {
            if ($key != "price" && $key != "name" && $value === "on") {
                array_push($categories, $key);
            }
        }
        return ($categories);
    }

    function create_article($post, $files) {
        if (isset($post) && isset($post["price"]) && isset($post["name"]) && isset($files) && !empty($post["price"]) && !empty($post["name"]) && !empty($files) && !empty($files["picture"])) {
            $name = $post["name"];
            $price = (int)$post["price"];
            if (explode("/", $files["picture"]["type"])[0] === "image") {
                $path_picture = "../pictures/".uniqid().".".explode("/", $files["picture"]["type"])[1];
                if (check_if_exists($name) === false) {
                    if (move_uploaded_file($files["picture"]["tmp_name"], $path_picture)) {
                        $categories = get_categories($post);
                        add_article($name, $price, $path_picture, $categories);
                        add_article_to_categories($name, $price, $path_picture, $categories);
                    }
                    else {
                        //error in upload
                    }
                }
                else {
                    // products exists
                }

            }
            else {
                //file is not a picture
            }
        }
    }