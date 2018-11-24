<?php
    require 'database.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }


    $nameError =  $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category =
    $image = "";   
    
    if(!empty($_POST))
{
        $name                       = checkInput($_POST['name']);
        $description                = checkInput($_POST['description']);
        $price                      = checkInput($_POST['price']);
        $category                   = checkInput($_POST['category']);
        $image                      = checkInput($_FILES['image']['name']);
        $imagePath                  = '../images/' . basename($image);
        $imageExtension             = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess                  = true;
        

        if(empty($name))
        {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($description))
        {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($price))
        {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($category))
        {
            $categoryError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image))
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" )
                {
                    $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                    $isUploadSuccess = false;
                }
                    if(file_exists($imagePath))
                {
                    $imageError = "Le fichier existe deja";
                    $isUploadSuccess = false;
                }
                if($_FILES["image"]["size"] > 500000)
                {
                    $imageError = "Le fichier ne doit pas depasser les 500KB";
                    $isUploadSuccess = false;
                }
                if($isUploadSuccess)
                {
                    if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                    {
                        $imageError = "Il y a eu une erreur lors de l'upload";
                        $isUploadSuccess = false;
                    }
                }
        }
    
    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
        {
            $db = Database::connect();
        if($isImageUpdated)
            {
            $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
            $statement->execute(array($name,$description,$price,$category,$image,$id));
            }
        else
            {
            $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?  WHERE id = ?");
            $statement->execute(array($name,$description,$price,$category,$id));
            }
            
            Database::disconnect();
            header("Location: index.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
        
        $db = Database::connect();
        $statement = $db->prepare("SELECT image FROM items where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $image          = $item['image'];
        Database::disconnect();

        }
    
    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM items WHERE id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name           = $item['name'];
        $description    = $item['description'];
        $price          = $item['price'];
        $category       = $item['category'];
        $image          = $item['image'];
        Database::disconnect();
    }

  


        function checkInput($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
    
        }
    
?>

<!DOCTYPE html>
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
             <h1 class="display-4">Modifier un item</h1>
        <div class="row">   
        <div class="col-sm-6">
        <form class="form-group" role="form" action="<?php echo 'update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">
  <div >
    <label for="name">Nom:</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
    <span class="help-inline"><?php echo $nameError; ?></span>
  </div>
  <div class="form-group">
  <label for="description">Description</label>
    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>" >
    <span class="help-inline">
    <?php echo $descriptionError; ?>
    </span>
  </div>
  <div class="form-group">
  <label for="price">Prix:</label>
    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>" >
    <span class="help-inline">
    <?php echo $priceError; ?>
    </span>
  </div>
  <div class="form-group">
  <label for="category">Catégorie:</label>
  <select class="form-control" id="category" name="category">
  <?php
    $db = Database::connect();
    foreach($db->query('SELECT * FROM categories') as $row)
    {
        if($row['id'] == $category)
            echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
        else
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';

    }
    Database::disconnect();

    ?>
  </select>
    <span class="help-inline">
    <?php echo $categoryError; ?>
    </span>
  </div>
  <br>
  <div class="form-group">
  <label>Image:</label>
  <p><?php echo $image; ?></p>
  <label for="image">Sélectionner une Image:</label>
    <input type="file" id="image" name="image>  
    <span class="help-inline"><?php echo $imageError;?></span>
  </div>
<br>
        <div class="form-actions">
        <a href="index.php" class="a btn btn-primary"><i class="fas fa-long-arrow-alt-left">&nbsp;</i>Retour</a>
        <button type="submit" class="btn btn-success"><i class="far fa-plus-square"></i> Modifier</button>
        </div>
        </form>
        
        </div>   
        <div class="site col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="<?php echo '../images/images/' . $image ; ?>" alt="Card image cap">
                            <div class="price text-center"><?php echo  number_format((float)$price,2,'.','') . ' €'; ?></div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $name; ?></h5>
                                <p class="card-text"><?php echo $description; ?></p>
                                <a href="#" class="a btn btn-danger">
                                    <i class="material-icons">
                                        shopping_cart
                                    </i>Commander</a>
                            </div>
                        </div>
                    </div>
  </div>
        </div>

<!--partie form -->

<br>
<!--div container site -->
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
crossorigin="anonymous"></script>
<script src="script.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>
</html>