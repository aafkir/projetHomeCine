<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Recherche</title>
  <link href="css/style_recherche.css" rel="stylesheet"/>
  <style>
    .pagination a {
      color: black;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
      color: white;
    }

    .pagination a.active {
      background-color: #4CAF50;
      color: white;
    }

    .pagination a:hover:not(.active) {
      background-color: #ddd;
    }
  </style>
</head>

<body>
<header>

  <div id="menubar">
    <ul>
      <li><a href="projet.php">Home</a></li>

      <li><a href="">Films</a>
        <ul>
          <?php
          $curl = curl_init('https://api.themoviedb.org/3/genre/movie/list?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR');
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $data = curl_exec($curl);
          $data = json_decode($data, true);
          $i = 0;
          foreach ($data['genres'] as $name) {
            $typesId[] = $data['genres'][$i]['id'];
            $typesName[] = $data['genres'][$i]['name'];

            echo "<li><a href='projet.php?id=$typesId[$i]&type=movie'>$typesName[$i]</a></li>";
            $i++;
          }; ?>
        </ul>
      </li>

      <li><a href="">Séries</a>
        <ul>
          <?php
          $curl = curl_init('https://api.themoviedb.org/3/genre/tv/list?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR');
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $data = curl_exec($curl);
          $data = json_decode($data, true);
          $i = 0;
          foreach ($data['genres'] as $name) {
            $typesIds[] = $data['genres'][$i]['id'];
            $typesNames[] = $data['genres'][$i]['name'];
            echo "<li><a href='projet.php?id=$typesIds[$i]&type=tv'>$typesNames[$i]</a></li>";
            $i++;
          }; ?>
        </ul>
      </li>
      <li><a href="statistics.php">Statistiques</a></li>
    </ul>
  </div>
</header>
<section id="bodypad" style="padding-bottom: 0">
  <div id="search">
    </form>
    <form method="get" action="recherche.php">
      <label for="research">Recherche:</label>
      <input type="text" id="research" name="research"/>
      <input type="submit" name="Envoyer" value="submit">
      <p><a href="recherche.php" style="text-align: right">Recherche avancée</a></p>
  </div>

  <h1 style="text-align: center; color: white; padding-top: 15px; font-size: 35px">Streaming</h1>

  <div id="moviesContainer">
    <?php
    include_once "fonctions.inc";
    $format = str_replace(" ", "+", $_GET['research']);
    $data = infos("https://api.themoviedb.org/3/search/" . $_GET['selectiontype'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&query=" . $format . "&page=1&include_adult=false");
    ismovieortv($data, $_GET['selectiontype']);

    ?>
  </div>
</section>

<footer>
  <?php /*
  */
  curl_close($curl)
  ?>
</footer>

</body>
</html>


