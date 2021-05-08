<?php

function set($url)
{
  if (!isset($url)) {
    if ((!isset($_GET['id']) && !isset($_GET['page']) && !isset($_GET['type']))) {
      return $getURL = "https://api.themoviedb.org/3/movie/popular?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&page=1";
    }
  } elseif ($url != null) {
    if ((isset($_GET['id']) && isset($_GET['page']) && isset($_GET['type']))) {
      return $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=" . $_GET['page'] . "&with_genres=" . $_GET['id'];
    } elseif (isset($_GET['id'])) {
      if (!isset($_GET['type']) && isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/movie?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=" . $_GET['page'] . "&with_genres=" . $_GET['id'];
      } elseif (isset($_GET['type']) && !isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=" . $_GET['id'];
      } elseif (!isset($_GET['type']) && !isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/movie?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=&with_genres=" . $_GET['id'];
      }
    } elseif (isset($_GET['type'])) {
      if (!isset($_GET['id']) && isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=" . $_GET['page'];
      } elseif (isset($_GET['id']) && !isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=" . $_GET['id'];
      } elseif (!isset($_GET['id']) && !isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1";
      }
    } elseif (isset($_GET['page'])) {
      if (isset($_GET['id']) && !isset($_GET['page'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/" . $_GET['type'] . "?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=" . $_GET['id'];
      } elseif (!isset($_GET['type']) && !isset($_GET['id'])) {
        return $getURL = "https://api.themoviedb.org/3/discover/movie?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=" . $_GET['page'];
      }
    } elseif (!isset($_GET['id']) && !isset($_GET['page']) && !isset($_GET['type'])) {
      return $getURL = "https://api.themoviedb.org/3/movie/popular?api_key=942a25114a90f847e13fc87324b25f5a&language=fr-FR&page=1";
    }
  }
}

function infos($url)
{
  $curl = curl_init("$url");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($curl);
  $data = json_decode($data, true);
  return $data;
}

function ismovieortv($data, $type)
{
  $i = 0;
  if ($type == "movie") {
    foreach ($data['results'] as $name) {
      $titles[] = $data['results'][$i]['title'];
      $imgs[] = "https://image.tmdb.org/t/p/w300" . $data['results'][$i]['poster_path'];
      /*$durations[] = $data['results'][$i]['runtime'];*/
      $overs[] = $data['results'][$i]['overview'];
      $ids[] = $data['results'][$i]['id'];
      ?>
      <div class="moviebox">
        <div class="container2">
          <?php echo "<a href='movie_details.php?idmovie=$ids[$i]&amp;&type=movie'>"; ?>
          <img src="<?php echo $imgs[$i] ?>" alt="" class="image"/>
          <div class="overlay">
            <section>
              <h2><?php echo $titles[$i] ?></h2>
            </section>
            <section
              style="padding-bottom: 5px; padding-top: 5px ;margin-bottom:3px; border-style: none none solid none;">
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
  } elseif ($type == "tv") {
    foreach ($data['results'] as $name) {
      $names[] = $data['results'][$i]['name'];
      $imgs[] = "https://image.tmdb.org/t/p/w300" . $data['results'][$i]['poster_path'];
      $overs[] = $data['results'][$i]['overview'];
      $ids[] = $data['results'][$i]['id'];
      ?>
      <div class="moviebox">
        <div class="container2">
          <?php echo "<a href='movie_details.php?idmovie=" . $ids[$i] . "&amp;type=tv'>"; ?>
          <img src="<?php echo $imgs[$i] ?>" alt="" class="image"/>
          <div class="overlay">
            <section>
              <h2><?php echo $names[$i] ?></h2>
            </section>
            <section
              style="padding-bottom: 5px; padding-top: 5px ;margin-bottom:3px; border-style: none none solid none;">
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
  }
}

function pagination($data){
  $page_total = $data['total_pages'];
  $current_page=$data['page'];
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

  }

}



