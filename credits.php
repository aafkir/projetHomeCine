<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8"/>
  <title>Streaming</title>
  <link href="css/styleProjet.css" rel="stylesheet"/>
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

<body>
<section id="bodypad" style="padding-bottom: 0">
  <div id="search">
    </form>
    <form method="get" action="">
      <label for="research">Recherche...</label>
      <input type="text" id="research" name="research"/>
      <input type="submit" name="Envoyer" value="submit">
      <p><a href="recherche.php" style="text-align: right">Recherche avancée</a></p>
  </div>

  <h1 style="text-align: center; color: white; padding-top: 15px; font-size: 35px">Streaming</h1>

  <?php
/*
  if (!isset($getURL) && !isset($_GET['id']) && !isset($_GET['type'])) {
    if (!isset($_GET['page'])) {
      $getURL = "https://api.themoviedb.org/3/movie/popular?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&page=1";
    } else {
      $getURL = "https://api.themoviedb.org/3/movie/popular?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&page=" . $_GET['page'];
    }
  }
  if (isset($_GET['id']) && $_GET['type'] == "movie") {
    if (!isset($_GET['page'])) {
      $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=" . $_GET['id'];
    } else {
      $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=" . $_GET['page'] . "&with_genres=" . $_GET['id'];
    }
  }
  if (isset($_GET['id']) && $_GET['type'] == "tv") {
    if (!isset($_GET['page'])) {
      $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&page=1&timezone=Europe%2FParis&with_genres=" . $_GET['id'] . "&include_null_first_air_dates=false";
    } else {
      $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&page=" . $_GET['page'] . "&timezone=Europe%2FParis&with_genres=" . $_GET['id'] . "&include_null_first_air_dates=false";
    }
  }
*/
  ?>


  <div id="moviesContainer">
    <?php

    $curl = curl_init("https://api.themoviedb.org/3/credit/" . $_GET['creditId'] . "?api_key=942a25114a90f847e13fc87324b25f5a");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    $data = json_decode($data, true);
    $imgURL = "https://image.tmdb.org/t/p/w300";
    $i = 0;

    foreach ($data['person']['known_for'] as $value) {
      if ($data['person']['known_for'][$i]['media_type'] == "movie") {
        $titles[] = $data['person']['known_for'][$i]['title'];
      } else {
        $titles[] = $data['person']['known_for'][$i]['name'];
      }
      $imgs[] = $imgURL . $data['person']['known_for'][$i]['poster_path'];
      $overs[] = $data['person']['known_for'][$i]['overview'];
      $ids[] = $data['person']['known_for'][$i]['id'];
      $t=$data['person']['known_for'][$i]['media_type'];?>
      <div class="moviebox"><?php echo "<a href='movie_details.php?idmovie=$ids[$i]&type=$t'>"; ?>

        <div class="container2">

          <img src="<?php echo $imgs[$i] ?>" alt="" class="image"/>
          <div class="overlay">
            <section>
              <h2><?php echo $titles[$i] ?></h2>
            </section>
            <section
              style="padding-bottom: 5px; padding-top: 5px ;margin-bottom:3px; border-style: none none solid none;">
              <p><?php /*echo $durations[$i] */ ?> min | <?php ?></p>
            </section>
            <section style="padding-top: 10px">
              <p><?php echo $overs[$i] ?>
              </p>
            </section>
          </div>
          </a>
        </div>
      </div>
      <?php
      $i++;
    }
    ?>

  </div>

</section>

<footer>
  <?php /*
  $page_total = $data['total_pages'];
  $class = "active";
  if ($current_page <= '1' && isset($_GET['id']) && isset($_GET['type'])) {
    echo "<div class='pagination'>";
    echo "<a href='projet.php?type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>&laquo;</a>";
    echo "<a class='active' href='projet.php?page=" . ($current_page) . "&type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>" . ($current_page) . "</a>";
    echo "<a href='projet.php?page=" . ($current_page + 1) . "&type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>" . ($current_page + 1) . "</a>";
    echo "<a href='projet.php?page=" . ($current_page + 2) . "&type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>" . ($current_page + 2) . "</a>";
    echo "<a class='' href=>...</a>";
    echo "<a class='' href=>" . ($page_total - 1) . "</a>";
    echo "<a class='' href=>$page_total</a>";
    echo "<a href=>&raquo;</a>";
    echo "</div>";
  } elseif ($current_page > '1' && isset($_GET['id']) && isset($_GET['type'])) {
    echo "<div class='pagination'>";
    echo "<a href='projet.php?type=" . $_GET['type'] . "&id=" . $_GET['id'] . ".'>&laquo;</a>";
    echo "<a class='' href='projet.php?page=" . ($current_page - 1) . "&type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>" . ($current_page - 1) . "</a>";
    echo "<a class='active' href='projet.php?page=" . ($current_page) . "&type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>" . ($current_page) . "</a>";
    echo "<a class='' href='projet.php?page=" . ($current_page + 1) . "&type=" . $_GET['type'] . "&id=" . $_GET['id'] . "'>" . ($current_page + 1) . "</a>";

    echo "<a class='' href=>...</a>";
    echo "<a class='' href=>" . ($page_total - 1) . "</a>";
    echo "<a class='' href=>$page_total</a>";
    echo "<a href=>&raquo;</a>";
    echo "</div>";
  } elseif ($current_page <= '1' && !isset($_GET['id']) && !isset($_GET['type']) && !isset($_GET['page'])) {
    echo "<div class='pagination'>";
    echo "<a href='projet.php?.'>&laquo;</a>";
    echo "<a class='active' href='projet.php?page=" . ($current_page) . "'>" . ($current_page) . "</a>";
    echo "<a href='projet.php?page=" . $current_page + 1 . "'>" . ($current_page + 1) . "</a>";
    echo "<a href='projet.php?page=" . ($current_page + 2) . "'>" . ($current_page + 2) . "</a>";
    echo "<a class='' href=>...</a>";
    echo "<a class='' href=>" . ($page_total - 1) . "</a>";
    echo "<a class='' href=>$page_total</a>";
    echo "<a href=>&raquo;</a>";
    echo "</div>";
  } elseif ($current_page > '1' && !isset($_GET['id']) && !isset($_GET['type'])) {
    echo "<div class='pagination'>";
    echo "<a href='projet.php?'>&laquo;</a>";
    echo "<a class='' href='projet.php?page=" . ($current_page - 1) . "'>" . ($current_page - 1) . "</a>";
    echo "<a class='active' href='projet.php?page=" . ($current_page) . "'>" . ($current_page) . "</a>";
    echo "<a class='' href='projet.php?page=" . ($current_page + 1) . "'>" . ($current_page + 1) . "</a>";

    echo "<a class='' href=>...</a>";
    echo "<a class='' href=>" . ($page_total - 1) . "</a>";
    echo "<a class='' href=>$page_total</a>";
    echo "<a href=>&raquo;</a>";
    echo "</div>";

  }*/
  curl_close($curl)
  ?>
</footer>

</body>
</html>

