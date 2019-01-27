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

function modify_category_name_in_articles($name, $new_name)
{
    $articles = unserialize(file_get_contents("../private/articles"));
    if (isset($articles) && !empty($articles)) {
        foreach ($articles as $key => $article) {
            for ($i = 0; $i < count($article["categories"]); $i++) {
                if ($article["categories"][$i] === $name) {
                    $articles[$key]["categories"][$i] = $new_name;
                }
            }
        }
    }
    file_put_contents("../private/articles", serialize($articles));
}

function modify_category_name($name, $new_name)
{
    $categories = unserialize(file_get_contents("../private/categories"));
    if (isset($categories) && !empty($categories)) {
        foreach ($categories as $key => $value) {
            if ($key === $name) {
                $category = $value;
                unset($categories[$key]);
                $categories[$new_name] = $category;
            }
        }
    }
    modify_category_name_in_articles($name, $new_name);
    file_put_contents("../private/categories", serialize($categories));
}

function modify_category($post)
{
    if (isset($post["categorie_name"])) {
       if (isset($post["categorie_name"]) && !empty($post["categorie_name"]) && isset($post["name"]) && !empty($post["name"])) {
           modify_category_name($post["categorie_name"], $post["name"]);
       }
        if (isset($post["categorie_name"]) && !empty($post["categorie_name"]) && isset($post["article_to_add"]) && !empty($post["article_to_add"])) {
            add_categories($post["article_to_add"], array($post["categorie_name"]));
        }
        if (isset($post["categorie_name"]) && !empty($post["categorie_name"]) && isset($post["article_to_delete"]) && !empty($post["article_to_delete"])) {
            delete_categories($post["article_to_delete"], array($post["categorie_name"]));
        }
   }
}

function delete_category($post)
{
    $name = $post["categorie_name"];
    $articles = unserialize(file_get_contents("../private/articles"));
    $categories = unserialize(file_get_contents("../private/categories"));
    if (isset($articles) && !empty($articles)) {
        foreach ($articles as $key => $article) {
            for ($i = 0; $i < count($article["categories"]); $i++) {
                if ($article["categories"][$i] === $name) {
                    unset($articles[$key]["categories"][$i]);
                    $articles[$key]["categories"] = array_values($articles[$key]["categories"]);
                }
            }
        }
    }
    if (isset($categories) && !empty($categories) && isset($categories[$name])) {
        unset($categories[$name]);
    }
    file_put_contents("../private/articles", serialize($articles));
    file_put_contents("../private/categories", serialize($categories));
}