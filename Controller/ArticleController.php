<?php

include("../Model/Article.php");


function htmldump($variable, $height = "300px")
{
    echo "<pre style=\"border: 1px solid #000; height: {$height}; overflow: auto; margin: 0.5em;\">";
    var_dump($variable);
    echo "</pre>\n";
}

function check_if_exists($name)
{
    $data = unserialize(file_get_contents("../private/articles"));
    if (isset($data) && !empty($data) && isset($data[$name])) {
        return (true);
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

function modify_name_in_categories($name, $new_name)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    foreach ($categories as $key => $category) {
        if (isset($category[$name])) {
            unset($categories[$key][$name]);
            $article = get_article($name);
            unset($article["categories"]);
            $categories[$key][$new_name] = $article;
        }
    }
    file_put_contents("../private/categories", serialize($categories));
}


function modify_name($name, $new_name)
{
    if (check_if_exists($new_name) === false) {
        $articles = unserialize(file_get_contents("../private/articles"));
        $article = $articles[$name];
        unset($articles[$name]);
        $articles[$new_name] = $article;
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
        if (isset($category[$name])) {
            $categories[$key][$name]["price"] = (int)$price;
        }
    }
    file_put_contents("../private/categories", serialize($categories));
}

function modify_price($name, $price)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    if (!empty($articles) && isset($articles[$name])) {
        $articles[$name]["price"] = (int)$price;
    }
    modify_price_in_categories($name, $price);
    file_put_contents("../private/articles", serialize($articles));
}

function article_is_in_category($name, $category)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    if (isset($categories[$category]) && isset($categories[$category][$name])) {
        return (true);
    }
    return (false);
}

function add_article_in_category($name, $category_to_add)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    $article = get_article($name);
    unset($article["categories"]);
    if (!empty($categories) && isset($categories[$category_to_add])) {
        $categories[$category_to_add][$name] = $article;
    }
    file_put_contents("../private/categories", serialize($categories));
}

function add_categories($name, $categories_to_add)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    if (isset($articles[$name])) {
        foreach ($categories_to_add as $key => $category) {
            if (article_is_in_category($name, $category) === false) {
                array_push($articles[$name]["categories"], $category);
                add_article_in_category($name, $category);
            }
        }
    }
    file_put_contents("../private/articles", serialize($articles));
}

function delete_article_in_category($name, $category_to_delete)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    if (!empty($categories) && isset($categories[$category_to_delete]) &&  isset($categories[$category_to_delete][$name])) {
        unset($categories[$category_to_delete][$name]);
        $categories[$category_to_delete] = array_values($categories[$category_to_delete]);
    }
    file_put_contents("../private/categories", serialize($categories));
}

function delete_categories($name, $categories_to_delete)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    foreach ($categories_to_delete as $key => $category_to_delete) {
        if (article_is_in_category($name, $category_to_delete) === true) {
            for ($i = 0; $i < count($articles[$name]["categories"]); $i++) {
                if ($articles[$name]["categories"][$i] === $category_to_delete) {
                    unset($articles[$name]["categories"][$i]);
                    $articles[$name]["categories"] = array_values($articles[$name]["categories"]);
                    delete_article_in_category($name, $category_to_delete);
                }
            }
        }
    }
    file_put_contents("../private/articles", serialize($articles));
}

function get_path_of_article($name)
{
    $article = get_article($name);
    $path = "";
    if (!empty($article)) {
        $path = $article["path"];
    }
    return ($path);
}

function add_picture($files)
{
    if (explode("/", $files["picture"]["type"])[0] === "image") {
        $path_picture = "../pictures/" . uniqid() . "." . explode("/", $files["picture"]["type"])[1];
        if (move_uploaded_file($files["picture"]["tmp_name"], $path_picture)) {
            return ($path_picture);
        }
    }
    return (false);
}

function update_path_name($article_name, $path)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    if (!empty($articles) && isset($articles[$article_name])) {
        $articles[$article_name]["path"] = $path;
    }
    file_put_contents("../private/articles", serialize($articles));
}

function modify_picture($name, $files)
{
    if (check_if_exists($name)) {
        $new_path = add_picture($files);
        if ($new_path !== false) {
            $old_path = get_path_of_article($name);
            unlink($old_path);
            update_path_name($name, $new_path);
        } else {
            // files didn't upload properly
        }
    } else {
        // article name doesnt exist
    }
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
    if (isset($post["article_name"]) && !empty($post["article_name"]) && isset($files) && !empty($files)) {
        modify_picture($post["article_name"], $files);
    }
}

function delete_article($post)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    $name = $post["article_name"];
    $article = get_article($name);
    if (!empty($articles)) {
        foreach ($article["categories"] as $category) {
            delete_article_in_category($name, $category);
        }
    }
    unset($articles[$name]);
    file_put_contents("../private/articles", serialize($articles));
}