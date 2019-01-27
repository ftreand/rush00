<?php
include("./header.php");
include("../Controller/ArticleController.php");

$articles = unserialize(file_get_contents('../private/articles'));
$categories = unserialize(file_get_contents('../private/categories'));

?>
<body>
<h1>Administration page</h1>

<div class="bloc_admin">

    <div class="bloc_inside_admin">
        <h2>Ajouter article</h2>
        <form method="post" enctype="multipart/form-data" action="../Redirection/handle_admin.php?action=add_article">
            <input type="file" name="picture" accept="image/*">
            <input type="number" name="price" value="prix">
            <input type="text" name="name" placeholder="nom">
            <p>Ajouter aux categories</p>
            <div class="checkboxs">
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $key => $category) {
                        echo "<input type='checkbox' name='" . $key . "'>" . $key . "</input>";
                    }
                }
                ?>
            </div>
            <input class="adding_button" type="submit" value="Ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Modifier article</h2>
        <form method="post" enctype="multipart/form-data" action="../Redirection/handle_admin.php?action=modify_article">
            <input type="file" name="picture" accept="image/*">
            <input type="number" name="price" value="prix">
            <input type="text" name="name" placeholder="nom">
            <select name="article_name">
                <?php
                if (!empty($articles)) {
                    foreach ($articles as $key => $article) {
                        echo "<option>" . $key . "</option>";
                    }
                }
                ?>
            </select>
            <p>Ajouter aux categories</p>
            <div class="checkboxs">
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $key => $category) {
                        echo "<input type='checkbox' name='add_categories[]' value='" . $key . "'>" . $key . "</input>";
                    }
                }
                ?>
            </div>
            <p>Supprimer des categories</p>
            <div class="checkboxs">
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $key => $category) {
                        echo "<input type='checkbox' name='delete_categories[]' value='" . $key . "'>" . $key . "</input>";
                    }
                }
                ?>
            </div>
            <input class="adding_button" type="submit" value="Modifier">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Supprimer article</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=delete_article">
            <select name="article_name">
                <?php
                if (!empty($articles)) {
                    foreach ($articles as $key => $article) {
                        echo "<option>" . $key . "</option>";
                    }
                }
                ?>
            </select>
            <input class="deleting_button" type="submit" value="Supprimer">
        </form>
    </div>

</div>


<div class="bloc_admin">

    <div class="bloc_inside_admin">
        <h2>Ajouter categorie</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=add_category">
            <input type="text" name="name" placeholder="nom">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Modifier categorie</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=modify_category">
            <h4>Selectionner categorie</h4>
            <select name="categorie_name">
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $key => $category) {
                        echo "<option>" . $key . "</option>";
                    }
                }
                ?>
            </select>

            <h4>Renommer categorie</h4>
            <input type="text" name="name" placeholder="nom">

            <h4>Ajouter article</h4>
            <select name="article_to_add">
                <option></option>
                <?php
                if (!empty($articles)) {
                    foreach ($articles as $key => $article) {
                        echo "<option>" . $key . "</option>";
                    }
                }
                ?>
            </select>

            <h4>Supprimer article</h4>
            <select name="article_to_delete">
                <option></option>
                <?php
                if (!empty($articles)) {
                    foreach ($articles as $key => $article) {
                        echo "<option>" . $key . "</option>";
                    }
                }
                ?>
            </select>

            <!-- add or delete-->
            <input class="adding_button" type="submit" value="modiier">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Supprimer categorie</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=delete_category">
            <select name="categorie_name">
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $key => $category) {
                        echo "<option>" . $key . "</option>";
                    }
                }
                ?>
            </select>
            <input class="adding_button" type="submit" value="supprimer">
        </form>
    </div>

</div>


<div class="bloc_admin">

    <div class="bloc_inside_admin">
        <h2>Ajouter utilisateur</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=add_user">
            <input type="text" name="name" placeholder="nom">
            <input type="text" name="password" placeholder="password">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Modifier utilisateur</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=modify_user">
            <!-- Lister utilisateurs-->
            <input type="text" name="name" value="nom">
            <input type="text" name="password" value="password">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Supprimer utilisateur</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=delete_user">
            <!-- Lister utilisateurs-->

            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

</div>

</body>
</html>