<?php

function add_article_to_categories($name, $price, $path, $article_categories)
{
    $categories = unserialize(file_get_contents('../private/categories'));
    $article = array("price" => $price, "path" => $path);
    foreach ($article_categories as $category_name) {
        if (isset($categories[$category_name])) {
            echo $category_name;
            if (!isset($categories[$category_name][$name])) {
                $categories[$category_name][$name] = $article;
            }
        }

    }
    file_put_contents("../private/categories", serialize($categories));
}

function add_article($name, $price, $path, $categories)
{
    $articles = unserialize(file_get_contents('../private/articles'));
    $new['price'] = $price;
    $new['path'] = $path;
    $new['categories'] = $categories;
    $articles[$name] = $new;
    file_put_contents("../private/articles", serialize($articles));
}

function get_article($name)
{
    $articles = unserialize(file_get_contents('../private/articles'));
    if (!empty($articles) && isset($articles[$name])) {
        return ($articles[$name]);
    }
    return ([]);
}










