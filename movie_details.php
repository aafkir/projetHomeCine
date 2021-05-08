<?php
    $getURL = "https://api.themoviedb.org/3/" . $_GET['type'] . "/" . $_GET['idmovie'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR";
    $curl = curl_init("$getURL");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $movieOrSerie = curl_exec($curl);
    $movieOrSerie = json_decode($movieOrSerie, true);
    $imgURL = "https://image.tmdb.org/t/p/w300";

    if ($_GET['type'] == "movie") {
        $title = $movieOrSerie['title'];
        $typeMovieOrSerie = 'film';
    } elseif ($_GET['type'] == "tv") {
        $title = $movieOrSerie['original_name'];
        $typeMovieOrSerie = 'serie';
    }

    // Cookie
    $year = time() + 3600 * 24 * 365;
    $valueCookie = json_encode([
        'type' => $typeMovieOrSerie,
        'nom' =>  $title,
        'date' => (new DateTime('now', new DateTimeZone('Europe/Paris')))->format('d/m/Y à H:i'),
    ]);
    setcookie(
            'last_movie', // clé du cookie
            $valueCookie, // valeur du cookie
            $year, // la durée de la garde du cookie
            null,  // chemin de cookie
            null,  // sur quelle domaine le cookie va être appliquer
            false, // securité : passer à true quand le site est en HTTPS
            true   // accès au cookie en HTTP
    );

    // Stocker l'historique des consultations des films ou series,
    // pour nous servir au statistique
    $statisticFile = fopen('statistics.csv', 'a+');
    $content = $title .'¤'. $typeMovieOrSerie .PHP_EOL;
    fwrite($statisticFile, $content);
    fclose($statisticFile);
?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8"/>
  <title>Détails</title>
  <link href="css/style_movie_details.css" rel="stylesheet"/>

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
<?php
if ($_GET['type'] == "movie") {
    $img = $imgURL . $movieOrSerie['poster_path'];
    $durations = $movieOrSerie['runtime'];
    $overs = $movieOrSerie['overview'];
    $budget = $movieOrSerie['budget'];
    $popularity = $movieOrSerie['popularity'];
    $revenue = $movieOrSerie['revenue'];
    $vote_average = $movieOrSerie['vote_average'];
    $vote_count = $movieOrSerie['vote_count'];
    $i = 0;
    foreach ($movieOrSerie['production_companies'] as $value) {
        $companies[] = $movieOrSerie['production_companies'][$i]['name'];
        $companies_logo[] = $imgURL . $movieOrSerie['production_companies'][$i]['logo_path'];
        $i++;
    }

    $curlvideo = curl_init("https://api.themoviedb.org/3/movie/" . $_GET['idmovie'] . "/videos?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR");
    curl_setopt($curlvideo, CURLOPT_RETURNTRANSFER, true);
    $datavideo = curl_exec($curlvideo);
    $datavideo = json_decode($datavideo, true);
    $trailer = $datavideo['results'][0]['key'] ?? null;

    $curlactors = curl_init("https://api.themoviedb.org/3/movie/" . $_GET['idmovie'] . "/credits?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR");
    curl_setopt($curlactors, CURLOPT_RETURNTRANSFER, true);
    $dataactors = curl_exec($curlactors);
    $dataactors = json_decode($dataactors, true);
  ?>

  <h1><?php echo $title . " (" . $durations . "mins)" ?> </h1>
  <div class="imgvid">
    <img src='<?php echo $img ?>' alt="" style="width: 18%; height: 40%; padding-left: 0;"/>
    <iframe width="960" height="555" src="https://www.youtube.com/embed/<?php echo $trailer ?>"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
  </div>

  <div class="overv">
    <h2>Résumé:</h2>
    <p style="padding-right: 34vh; text-align: justify">
      <?php
      echo $overs;
      ?>
    </p>
  </div>

  <div style="padding-left: 10vw; padding-right: 58vh">
    <h2>Acteurs:</h2>
    <?php
    $i = 0;
    foreach ($dataactors['cast'] as $info) {
      if ($dataactors['cast'][$i]['known_for_department'] == "Acting") {
        $actors[] = $dataactors['cast'][$i]['name'];
        $character[] = $dataactors['cast'][$i]['character'];
        $actimg[] = $imgURL . $dataactors['cast'][$i]['profile_path'];
        $credits[] = $dataactors['cast'][$i]['credit_id'];

        echo "<div class='actors' style='padding-right: 5vh'>";
        echo "<img src='$actimg[$i]' alt='$actors[$i]' style='width: 100px; height: 150px; padding-left: 12px ;'/>";
        echo "<p style='margin: 0; padding: 0'>Acteur: <a href='credits.php?creditId=$credits[$i]'>$actors[$i]</a></p>";
        echo "<p style='margin-top: 0; margin-bottom: 0'>Perso: " . $character[$i] . "</p>";
        echo "</div>";

        $i++;
      }
    }
    ?>
  </div>

  <div class="stats" style="padding-top: 40px">
    <p><?php echo "Budget:" . $budget ?> &#36; </p>
    <p><?php echo "Revenue:" . $revenue ?> &#36;</p>
    <p><?php echo "Popularity:" . $popularity ?></p>
    <p><?php echo "Note:" . $vote_average ?></p>
    <p><?php echo "Votes:" . $vote_count ?></p>
    <ul>
      <?php
      $i = 0;
      foreach ($movieOrSerie['production_companies'] as $value) {
        $companies[] = $movieOrSerie['production_companies'][$i]['name'];
        $companies_logo[] = $imgURL . $movieOrSerie['production_companies'][$i]['logo_path'];
        echo "<li>$companies[$i]</li>";
        echo "<li><img src='$companies_logo[$i]' alt='' style='width: 18%; height: 40%; padding-left: 0; padding-top: 30px'/></li>";
        $i++;
      }
      ?>
    </ul>
  </div>

  <?php


}

elseif ($_GET['type'] == "tv") {
  $img = $imgURL . $movieOrSerie['poster_path'];
  $i = 0;
  foreach ($movieOrSerie['episode_run_time'] as $value) {
    $durations = $movieOrSerie['episode_run_time'][$i];
  }
  $releasefirst = $movieOrSerie['first_air_date'];
  $nbepisode = $movieOrSerie['number_of_episodes'];
  $seasons = $movieOrSerie['number_of_seasons'];
  $overs = $movieOrSerie['overview'];
  $popularity = $movieOrSerie['popularity'];
  $vote_average = $movieOrSerie['vote_average'];
  $vote_count = $movieOrSerie['vote_count'];
  $i = 0;
  if ($movieOrSerie['production_companies'] != null) {
    foreach ($movieOrSerie['production_companies'] as $value) {
      $companies[] = $movieOrSerie['production_companies'][$i]['name'];
      $companies_logo[] = $imgURL . $movieOrSerie['production_companies'][$i]['logo_path'];
      $i++;
    }
  }

  $curlvideo = curl_init("https://api.themoviedb.org/3/" . $_GET['type'] . "/" . $_GET['idmovie'] . "/videos?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR");
  curl_setopt($curlvideo, CURLOPT_RETURNTRANSFER, true);
  $datavideo = curl_exec($curlvideo);
  $datavideo = json_decode($datavideo, true);
  $trailer = $datavideo['results'][0]['key'] ?? null;

  $curlactors = curl_init("https://api.themoviedb.org/3/" . $_GET['type'] . "/" . $_GET['idmovie'] . "/credits?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR");
  curl_setopt($curlactors, CURLOPT_RETURNTRANSFER, true);
  $dataactors = curl_exec($curlactors);
  $dataactors = json_decode($dataactors, true);
  ?>
  <h1><?php echo $title . " (" . $durations . "mins)" ?> </h1>
  <div class="imgvid">
    <img src='<?php echo $img ?>' alt=""/>
    <iframe src="https://www.youtube.com/embed/<?php echo $trailer ?>"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
  </div>

  <div class="overv">
    <h2>Résumé:</h2>
    <p style="padding-right: 34vh; text-align: justify">
      <?php
      echo $overs;
      ?>
    </p>
  </div>

  <div style="padding-left: 10vw; padding-right: 58vh">
    <h2>Acteurs:</h2>
    <?php
    $i = 0;
    foreach ($dataactors['cast'] as $info) {
      if ($dataactors['cast'][$i]['known_for_department'] == "Acting") {
        $actors[] = $dataactors['cast'][$i]['name'];
        $character[] = $dataactors['cast'][$i]['character'];
        $actimg[] = $imgURL . $dataactors['cast'][$i]['profile_path'];
        $credits[] = $dataactors['cast'][$i]['credit_id'];
        echo "<div class='actors' style='padding-right: 5vh'>";
        echo "<img src='$actimg[$i]' alt='$actors[$i]' style='width: 100px; height: 150px; padding-left: 12px ;'/>";
        echo "<p style='margin: 0; padding: 0'>Acteur: <a href='credits.php?creditId=$credits[$i]'>$actors[$i]</a></p>";
        echo "<p style='margin-top: 0; margin-bottom: 0'>Perso: " . $character[$i] . "</p>";
        echo "</div>";
        $i++;
      }
    }
    ?>

  </div>

  <div class="stats">
    <p><?php echo "Nombre de saison: " . $seasons ?></p>
    <p><?php echo "Nombre d'épisode: " . $nbepisode ?></p>
    <p><?php echo "Popularity: " . $popularity ?></p>
    <p><?php echo "Note: " . $vote_average ?></p>
    <p><?php echo "Votes: " . $vote_count ?></p>
    <ul>
      <?php
      $i = 0;
      foreach ($movieOrSerie['production_companies'] as $value) {
        $companies[] = $movieOrSerie['production_companies'][$i]['name'];
        $companies_logo[] = $imgURL . $movieOrSerie['production_companies'][$i]['logo_path'];
        echo "<li>$companies[$i]</li>";
        echo "<li><img src='$companies_logo[$i]' alt='' style='width: 18%; height: 40%; padding-left: 0; padding-top: 30px'/></li>";
        $i++;
      }
      ?>
    </ul>
  </div>
  <?php
}
?>
</body>
