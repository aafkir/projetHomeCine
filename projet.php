<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8"/>
  <title>StreamInfos</title>
  <link href="css/styleProjet.css" rel="stylesheet"/>
  <style>
    .pagination {
      display: inline-block;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
      color: white;
    }

    .pagination a.active {
      background-color: #c40e0e;
      color: white;
    }

    .pagination a:hover:not(.active) {
      background-color: orange;
    }
  </style>
</head>

<body>
<?php include_once "fonctions.inc"; ?>
<header>
  <div id="menubar">
    <ul>
      <li><a href="projet.php">Home</a></li>

      <li><a href="">Films</a>
        <ul>
          <?php
          $data = infos('https://api.themoviedb.org/3/genre/movie/list?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR');
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
          $data = infos('https://api.themoviedb.org/3/genre/tv/list?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR');
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
    <form style="color: white" method="get" action="recherche.php">
      <input type="radio" id="movie" name="selectiontype" value="movie">
      <label for="selectiontype">Film</label><br>
      <input type="radio" id="serie" name="selectiontype" value="tv">
      <label for="selectiontype">Série</label><br>
      <label for="research" style="font-size: 20px">Recherche:</label>
      <input
        style="width: 25vw; height: 3vh; font-size: 20px; border-radius: 20px; border: solid 3px white; padding-left: 15px;background-color: lightgrey"
        type="text" id="research" name="research"/>
    </form>
    <p><a href="recherche.php" style="text-align:justify; padding-left: 14vw; font-size: 20px">Recherche avancée</a></p>
  </div>

  <h1 style="text-align: center; color: white; padding-top: 15px; font-size: 35px">StreamInfos</h1>

  <div id="moviesContainer">
    <?php

    $getURL = set("init");
    $data = infos($getURL);
    if (!isset($_GET['type'])) {
      $_GET['type'] = "movie";
    }
    ismovieortv($data, $_GET['type']);
    ?>

  </div>

</section>

<footer>
  <div class="pagination">
    <?php

    if (!isset($_GET['page']) || $_GET['page'] < 1) {
      $_GET['page'] = 1;
    }
    echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=1'>&laquo;</a>";
    if ($_GET['page'] > 1) {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] - 1) . "'>&laquo;</a>";
    } else {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] . "'>&laquo;</a>";
    }

    for ($i = 1;
         $i < 6;
         $i++) {
    ?>

    <a
      <?php if ($_GET['page'] == 1 && $i == 1 || $_GET['page'] == 2 && $i == 2) {
        echo "class='active'";
      } /*elseif ($_GET['page'] == 2 && $i == 2) {
      echo "class='active'";
    } */elseif ($i == 3 && $_GET['page'] >= 3) {
        echo "class='active'";
      } ?>
      href="projet.php?<?php if ($_GET['page'] == 1) {
      echo "type=" . $_GET['type'] . "&id=" . $_GET['id'] . "&page=" . $_GET['page'] * $i ?>"> <?php echo $_GET['page'] * $i;
      } elseif ($_GET['page'] == 2 || $_GET['page'] == 3) {
        echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] * $i)/$_GET['page'] ?>"> <?php echo ($_GET['page'] * $i) / $_GET['page'];
      } else {
        echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] + $i - 3 ?>"> <?php echo $_GET['page'] + $i - 3;
      }
      }
      ?></a>
    <?php
    if ($_GET['page'] < $data['total_pages']) {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] + 1) . "'>&raquo;</a>";
    } else {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] . "'>&raquo;</a>";
    }
    echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $data['total_pages'] . "'>&raquo;</a>";
    ?>
  </div>

</footer>

</body>
</html>
