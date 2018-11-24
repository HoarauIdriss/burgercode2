

<!-- php -->

<?php
    require 'database.php';
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);

    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category
    FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?');

    

    $statement->execute(array($id));
    $item = $statement->fetch();

    Database::disconnect();




    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }



?>



<!doctype html>
<html lang="en">

<head>
    <title>Burger Code By Idriss</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--style.css-->
    <link rel="stylesheet" href="../style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!--CDN icone google-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--CDN fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>

<body>
<div class="container site text-center">
<h1 class="H1 text-logo">
            <i class="material-icons">restaurant</i>
            Burgercode
            <i class="material-icons">restaurant</i>
        </h1>

  <div class="admin container">
    <h1 class="display-4">Admin</h1>
    
    <div class="row"> 
        <div class="col-sm-6">
        <p class="lead"><strong>Voir un item</strong></p>
        <br>
        <form>
            <div class="form-group">
               <label>Nom:</label><?php echo '  ' . $item['name']; ?>
            </div>
            <div class="form-group">
                <label>Description:</label><?php echo '  ' . $item['description']; ?>
            </div>
            <div class="form-group">
                <label>Prix:</label><?php echo '  ' . number_format((float)$item['price'],2,'.','') . ' €'; ?>
            </div>
            <div class="form-group">
                <label>Catégorie:</label><?php echo '  ' . $item['category']; ?>
            </div>
            <div class="form-group">
                <label>Image:</label><?php echo '  ' . $item['image']; ?>
            </div>
        </form>
        <br>
        <div class="fom-actions">
            <a href="index.php" class="a btn btn-primary"><i class="fas fa-long-arrow-alt-left">&nbsp;</i>Retour</a>
        </div>
   </div>
   <div class="site col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="<?php echo '../images/images/' . $item['image'] ; ?>" alt="Card image cap">
                            <div class="price text-center"><?php echo  number_format((float)$item['price'],2,'.','') . ' €'; ?></div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text"><?php echo $item['description']; ?></p>
                                <a href="#" class="a btn btn-danger">
                                    <i class="material-icons">
                                        shopping_cart
                                    </i>Commander</a>
                            </div>
                        </div>
                    </div>
  </div>
 </div> 
</div>














<script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>