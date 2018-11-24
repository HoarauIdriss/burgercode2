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
            <h5 class="col-sm-3"><strong>Liste des items</strong></h5>
            
           
            <a href="insert.php"  class="btn btn-success mb-2 "><i class="far fa-plus-square"></i>&nbsp;Ajouter</a>

<div class="container">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Description</th>
      <th scope="col">Prix</th>
      <th scope="col">Catégorie</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
      <?php
      Require 'database.php';
      $db = Database::connect();
      $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category
                                FROM items LEFT JOIN categories ON items.category = categories.id
                                ORDER BY items.id DESC');
      while($item = $statement->fetch())
      {
      echo '<tr>';
      echo '<td>' . $item['name'] . '</td>';
      echo '<td>' . $item['description'] . '</td>';
      echo '<td>' . number_format((float)$item['price'],2,'.','') . '</td>';
      echo '<td>' . $item['category'] . '</td>';
      echo '<td width=300>';
      echo '<a href="view.php?id=' . $item['id'] . '"  class="btn btn-secondary  "><i class="far fa-eye"></i>&nbsp;Voir</a>';
      echo ' ';
      echo '<a href="update.php?id=' . $item['id'] . '"  class="btn btn-primary  "><i class="fas fa-pencil-alt"></i>&nbsp;Modifier</a>';
      echo ' ';
      echo '<a href="delete.php?id=' . $item['id'] . '"  class="btn btn-danger  "><i class="fas fa-times"></i>&nbsp;Supprimer</a>';
      echo '</td>';
      echo '</tr>';
      }
      Database::disconnect();
      ?>

  </tbody>
</table>


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