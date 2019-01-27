<?php

$categories = unserialize(file_get_contents("../private/categories"));
$articles = unserialize(file_get_contents("../private/articles"));
$users = unserialize(file_get_contents("../private/passwd"));


function htmldump($variable, $height = "300px")
{
    echo "<pre style=\"border: 1px solid #000; height: {$height}; overflow: auto; margin: 0.5em;\">";
    var_dump($variable);
    echo "</pre>\n";
}

?>

<h1>Articles</h1>

<?php echo htmldump($articles) ?>


<h1>Categories</h1>

<?php echo htmldump($categories) ?>


<h1>Users</h1>

<?php echo htmldump($users) ?>
