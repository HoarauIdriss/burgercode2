
<?php
    require 'database.php';
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
        $isUploadSuccess            = false;

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
            $imageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else
        {
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
                if($_FILES["image"]["size"] > 800000)
                {
                    $imageError = "Le fichier ne doit pas depasser les 800KB";
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
    
        if($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name,description,price,category,image) values(?, ?, ?, ?, ?)");
            $statement->execute(array($name,$description,$price,$category,$image));
            Database::disconnect();
            header("Location: index.php") ;
        }
    
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
             <h1 class="display-4">Ajouter un item</h1>
        <div class="row">       
        </div>

<!--partie form -->
<form class="form-group" role="form" action="insert.php" method="post" enctype="multipart/form-data">
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
  <label for="image">Sélectionner une Image:</label>
    <input type="file" id="image" name="image"  value="<?php echo $image; ?>" >
    <span class="help-inline"><?php echo $imageError;?></span>
  </div>

        <div class="fom-actions">
        <a href="index.php" class="a btn btn-primary"><i class="fas fa-long-arrow-alt-left">&nbsp;</i>Retour</a>
        <button type="submit" class="btn btn-success"><i class="far fa-plus-square"></i> Ajouter</button>
        </div>
        </form>
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