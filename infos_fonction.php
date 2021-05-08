<?php

  $apiKey = '942a25114a90f847e13fc87324b25f5a';
  $url = 'https://api.themoviedb.org/3';
  $movieUrl = $url . "/movie";
  $genreUrl = $url . "/genre/movie/list";
  $moviesUrl = $url . "/discover/movie";
  $personUrl = $url . "/trending/personn/week";
  $imgURL = "https://image.tmdb.org/t/p/w300";


  $curl = curl_init('https://api.themoviedb.org/3/movie/28?api_key=942a25114a90f847e13fc87324b25f5a&language=en-US');

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $data = curl_exec($curl);

  $data = json_decode($data, true);

  $img = $imgURL . $data['poster_path'];

  $title = $data['original_title'];

  $over = $data['overview'];

  $release = $data['release_date'];

  $duration = $data['runtime'];

  $popularity= $data['popularity'];

  $vote_average=$data['vote_average'];

  $vote_count=$data['vote_count'];


$i=0;
foreach ($data['genres'] as $name){
  $result[$i]= $data['genres'][$i]['name'];
  $i++;
}
echo '<pre>';
echo $title."\n";
echo $over."\n";
echo $release."\n";
echo $duration."\n";
echo $result[0]."\n";
echo $result[1]."\n";
echo '<img src='.$img.' alt="" />'."\n";
echo $popularity."\n";
echo $vote_average."\n";
echo $vote_count."\n";
echo '</pre>';
?>
