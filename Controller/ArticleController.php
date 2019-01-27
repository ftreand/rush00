<?php

include("../Model/Article.php");

function check_if_exists($name)
{
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

function get_categories($post)
{
    $categories = [];
    foreach ($post as $key => $value) {
        if ($key != "price" && $key != "name" && $value === "on") {
            array_push($categories, $key);
        }
    }
    return ($categories);
}

function create_article($post, $files)
{
    if (isset($post) && isset($post["price"]) && isset($post["name"]) && isset($files) && !empty($post["price"]) && !empty($post["name"]) && !empty($files) && !empty($files["picture"])) {
        $name = $post["name"];
        $price = (int)$post["price"];
        if (explode("/", $files["picture"]["type"])[0] === "image") {
            $path_picture = "../pictures/" . uniqid() . "." . explode("/", $files["picture"]["type"])[1];
            if (check_if_exists($name) === false) {
                if (move_uploaded_file($files["picture"]["tmp_name"], $path_picture)) {
                    $categories = get_categories($post);
                    add_article($name, $price, $path_picture, $categories);
                    add_article_to_categories($name, $price, $path_picture, $categories);
                } else {
                    //error in upload
                }
            } else {
                // products exists
            }

        } else {
            //file is not a picture
        }
    }
}

function htmldump($variable, $height = "300px")
{
    echo "<pre style=\"border: 1px solid #000; height: {$height}; overflow: auto; margin: 0.5em;\">";
    var_dump($variable);
    echo "</pre>\n";
}

function modify_name_in_categories($name, $new_name)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    foreach ($categories as $key => $category) {
        for ($i = 0; $i < count($category) - 1; $i++) {
            if ($category[$i]["name"] === $name) {
                $categories[$key][$i]["name"] = $new_name;
            }
        }
    }
    file_put_contents("../private/categories", serialize($categories));
}

function modify_name($name, $new_name)
{
    if (check_if_exists($new_name) === false) {
        $articles = unserialize(file_get_contents("../private/articles"));
        foreach ($articles as $key => $value) {
            if ($value["name"] === $name) {
                $articles[$key]["name"] = $new_name;
            }
        }
        modify_name_in_categories($name, $new_name);
        file_put_contents("../private/articles", serialize($articles));
    } else {
        // new article name is already taken;
    }
}


function modify_price_in_categories($name, $price)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    foreach ($categories as $key => $category) {
        for ($i = 0; $i < count($category) - 1; $i++) {
            if ($category[$i]["name"] === $name) {
                $categories[$key][$i]["price"] = $price;
            }
        }
    }
    file_put_contents("../private/categories", serialize($categories));
}

function modify_price($name, $price)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    foreach ($articles as $key => $value) {
        if ($value["name"] === $name) {
            $articles[$key]["price"] = (int)$price;
        }
    }
    modify_price_in_categories($name, $price);
    file_put_contents("../private/articles", serialize($articles));
}


function article_is_in_category($name, $category)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    foreach ($categories as $value) {
        if ($value["name"] === $category) {
            for ($i = 0; $i < count($value) - 1; $i++) {
                if ($value[$i]["name"] === $name) {
                    return (true);
                }
            }
        }
    }
    return (false);
}

function add_categories($name, $categories_to_add)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    $articles = unserialize(file_get_contents("../private/articles"));
    $article = get_article($name);
    unset($article["categories"]);
    foreach ($categories_to_add as $value) {
        if (article_is_in_category($name, $value) === false) {
            for ($i = 0; $i < count($categories); $i++) {
                if ($categories[$i]["name"] === $value) {
                    array_push($categories[$i], $article);
                    for ($index = 0; $index < count($articles); $index++) {
                        if ($articles[$index]["name"] === $name) {
                            array_push($articles[$index]["categories"], $value);
                        }
                    }
                }
            }

        } else {
            // article is already in category
        }
    }
    file_put_contents("../private/articles", serialize($articles));
    file_put_contents("../private/categories", serialize($categories));
}


function delete_categories($name, $categories_to_delete)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    $articles = unserialize(file_get_contents("../private/articles"));
    foreach ($categories_to_delete as $value) {
        if (article_is_in_category($name, $value) === true) {
            for ($i = 0; $i < count($categories); $i++) {
                if ($categories[$i]["name"] === $value) {
                    for ($index = 0; $index < count($categories[$i]) - 1; $index++) {
                        if ($categories[$i][$index]["name"] === $name) {
                            unset($categories[$i][$index]);
                        }
                    }
                }
            }

        } else {
            // article is already in category
        }
    }
    foreach ($articles as $key => $article) {
        if ($article["name"] === $name) {
            for ($i = 0; $i < count($article["categories"]); $i++) {
//                echo htmldump($article["categories"][$i]);
                if (in_array($article["categories"][$i], $categories_to_delete)) {
//                    echo htmldump($article["categories"][$i]);
//                    echo htmldump($article["categories"][$i]);
                    unset($articles[$key]["categories"][$i]);
                    $articles[$key]["categories"] = array_values($articles[$key]["categories"]);
                }
            }
        }
    }
    file_put_contents("../private/articles", serialize($articles));
    file_put_contents("../private/categories", serialize($categories));
}

function modify_article($post, $files)
{
    if (isset($post["article_name"]) && !empty($post["article_name"]) && isset($post["name"]) && !empty($post["name"])) {
        modify_name($post["article_name"], $post["name"]);
    }
    if (isset($post["article_name"]) && !empty($post["article_name"]) && isset($post["price"]) && !empty($post["price"])) {
        modify_price($post["article_name"], $post["price"]);
    }
    if (isset($post["article_name"]) && !empty($post["article_name"]) && isset($post["add_categories"]) && !empty($post["add_categories"])) {
        add_categories($post["article_name"], $post["add_categories"]);
    }
    if (isset($post["article_name"]) && !empty($post["article_name"]) && isset($post["delete_categories"]) && !empty($post["delete_categories"])) {
        delete_categories($post["article_name"], $post["delete_categories"]);
    }

//        var_dump($post);
//        var_dump($files);


}
















