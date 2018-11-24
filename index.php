<!doctype html>
<html lang="en">

<head>
    <title>Burger Code By Idriss</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Responsive meta tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--style.css-->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!--CDN icone google-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--CDN fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</head>

<body>


    <div class="container site text-center">
        <h1 class="H1 text-logo">
            <i class="material-icons">restaurant</i>
            Burgercode
            <i class="material-icons">restaurant</i>
        </h1>
        
<?php
require 'admin/database.php';
echo '<ul class="nav nav-tabs" id="myTab" role="tablist">';


$db =Database::connect();
$statement = $db->query('SELECT * FROM categories');
$categories = $statement->fetchAll();
foreach($categories as $category)
{
    if($category['id'] == '1')
    
        echo '<li class="nav-item"><a class="nav-link active" id="nav-tab" data-toggle="tab" href="#' . $category['name'] . '" role="tab" aria-controls="Menus" aria-selected="true">' .$category['name']. '</a></li>';
    
       
    else
    
        echo '<li class="nav-item"><a class="nav-link" id="nav-tab" data-toggle="tab" href="#' . $category['name'] . '" role="tab"  aria-controls="Burgers" aria-selected="true">' .$category['name']. '</a></li>';
    
    
}
    echo '</li>
    </ul>';

    echo '<div class="tab-content">';

    foreach($categories as $category)
    {
        if($category['id'] == '1')
        {
            echo '<div class="tab-pane active" id="' . $category['name'] . '" role="tabpanel" aria-labelledby="Menus-tab">';
        }
        
        else
        {
            echo '<div class="tab-pane " id="' . $category['name'] . '" role="tabpanel" aria-labelledby="Menus-tab">';
        }
        
            echo '<div class="row">';

        

        $statement =$db->prepare('SELECT * FROM items WHERE items.category = ?');
        $statement->execute(array($category['id']));

        while($item = $statement->fetch())
        {
           echo '<div class="col-sm-6 col-md-4">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="images/images/' . $item['image'] . '" alt="Card image cap">
                <div class="price text-center">' . number_format($item['price'], 2, '.', ''). ' €</div>
                <div class="card-body">
                    <h5 class="card-title">' . $item['name'] . '</h5>
                    <p class="card-text">' . $item['description'] . '</p>
                    <a href="#" class="a btn btn-danger">
                        <i class="material-icons">shopping_cart</i>Commander</a>
                </div>
            </div>
        </div>';
        }
        echo '</div>
        </div>';


    }
    Database::disconnect();
    echo '</div>';

?>
        <!--nav tab-->
        
            


        <!--                        nav tab         Menus            -->

        
            
                
                   

                    

    <!---->








    
    <footer></footer>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    

</body>

</html>