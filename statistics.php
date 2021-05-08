<?php
    $lastMovieOrSerieVisited = null;
    if (isset($_COOKIE['last_movie'])) {
        // récuperer le cookie et le converture en tableau
        $lastMovieOrSerieVisited = json_decode($_COOKIE['last_movie'], true);
    }

    $result = [
        'film' => [],
        'serie' => [],
    ];

    $statisticFile = fopen('statistics.csv', 'r');
    /*
     * Tant que la fin du fichier n'est pas atteninte, c'est-à-dire, tant que feof() renvoie FALSE
     */
    while(!feof($statisticFile)){
        $ligne = fgets($statisticFile);
        $explodeLigne = explode('¤', $ligne);
        if (count($explodeLigne) < 2) {
            continue;
        }
        $type = trim((string) $explodeLigne[1]);

        $name = $explodeLigne[0];
        if (strlen($name) > 16) {
            $name = substr($name, 0, 25). '...';
        }
        if (!isset($result[$type][$name])) {
            $result[$type][$name] = 0;
        }
        ++$result[$type][$name];
    }

    $films = $result['film'];
    // tri
    arsort($films);

    $series = $result['serie'];
    // tri
    arsort($series);
?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8"/>
  <title>Statistique</title>
  <link href="css/style_movie_details.css" rel="stylesheet"/>
</head>

<body>
    <header>
    <div id="menubar">
        <ul>
            <li><a href="projet.php">Home</a></li>

            <li>
                <a href="">Films</a>
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
    <div class="cs-container">
        <div>
            <h2>Dernière film ou série consulté :</h2>
            <?php
            if ($lastMovieOrSerieVisited) {
            echo <<<HTML
                         <div class="animated-progress  d-inline-table">
                             <span data-progress="100" data-content="{$lastMovieOrSerieVisited['nom']}"></span>
                            </div>
                            <div><small>Le {$lastMovieOrSerieVisited['date']}</small></div> 
HTML;
            }
            ?>
        </div>
        <h1>Statistiques</h1>
        <div class="statistic">
            <div class="d-inline-flex">
                <div>
                    <h2>Films :</h2>
                </div>
            </div>
            <div class="d-inline-flex cs-series">
                <div>
                    <h2>Séries :</h2>
                </div>
            </div>
        </div>
        <div class="statistic">
            <div class="d-inline-flex">
                <?php
                    foreach ($films as $name => $count) {
                        $vues = 'vue'.($count > 1 ? 's' : '');
                        echo <<<HTML
                             <div class="animated-progress " style="background-color:blue " >
                                 <span >$name ($count $vues) </span>
                                </div>
HTML;
                    }
                ?>
            </div>
            <div class="d-inline-flex">
                <?php
                foreach ($series as $name => $count) {
                    $vues = 'vue'.($count > 1 ? 's' : '');
                    echo <<<HTML
                             <div class="animated-progress " style="background-color:green ">
                                 <span>$name ($count $vues)></span>
                                </div>
HTML;
                }
                ?>
            </div>
        </div>

    </div>

</body>
