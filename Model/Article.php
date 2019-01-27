<?php

function add_article_to_categories($name, $price, $path, $article_categories)
{
    $categories = unserialize(file_get_contents('../private/categories'));
    $article = array("name" => $name, "price" => $price, "path" => $path);
    foreach ($categories as $key => $value) {
        foreach ($article_categories as $category) {
            if ($value["name"] === $category) {
                $categories[$key][] = $article;
            }
        }
    }
    file_put_contents("../private/categories", serialize($categories));
}

function add_article($name, $price, $path, $categories)
{
    $articles = unserialize(file_get_contents('../private/articles'));
    $new['name'] = $name;
    $new['price'] = $price;
    $new['path'] = $path;
    $new['categories'] = $categories;
    $articles[] = $new;
    file_put_contents("../private/articles", serialize($articles));
}

function get_article($name)
{
    $articles = unserialize(file_get_contents('../private/articles'));
    if (!empty($articles)) {
        foreach ($articles as $article) {
            if ($article["name"] === $name) {
                return ($article);
            }
        }
    }
    return ([]);
}