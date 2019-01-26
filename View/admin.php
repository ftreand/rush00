<?php
include("./header.php");
include("../Controller/ArticleController.php");

$articles = unserialize(file_get_contents('../private/article'));

?>
<body>
<h1>Administration page</h1>


<?php
    print_r($articles);

?>



<div class="bloc_admin">

    <div class="bloc_inside_admin">
        <h2>Ajouter article</h2>
        <form method="post" enctype="multipart/form-data"  action="../Redirection/handle_admin.php?action=add_article">
            <input type="file" name="picture" accept="image/*">
            <input type="number" name="price" value="prix">
            <input type="text" name="name" placeholder="nom">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Modifier article</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=modify_article">
            <input type="file" name="picture">
            <input type="number" name="price" value="prix">
<!--            <input type="text" name="name" value="nom">-->
            <select>
                <?php
                    foreach ($articles as $article) {
                        echo "<option>".$article["name"]."</option>";
                    }
                ?>
            </select>
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Supprimer article</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=delete_article">
            <input type="text" name="name" placeholder="nom">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

</div>


<div class="bloc_admin">

    <div class="bloc_inside_admin">
        <h2>Ajouter categorie</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=add_categorie">
            <input type="text" name="name" placeholder="nom">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Modifier categorie</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=modify_categorie">
            <input type="text" name="name" value="nom">
            <input type="text" name="product" value="product">
            <!-- add or delete-->
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

    <div class="bloc_inside_admin">
        <h2>Supprimer categorie</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=delete_categorie">
            <input type="text" name="name" value="nom">
            <input class="adding_button" type="submit" value="ajouter">
        </form>
    </div>

</div>



<div class="bloc_admin">

    <div class="bloc_inside_admin">
        <h2>Ajouter utilisateur</h2>
        <form method="post" action="../Redirection/handle_admin.php?action=add_user">
            <input type="text" name="name" value="nom">
            <input type="text" name="password" value="password">
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