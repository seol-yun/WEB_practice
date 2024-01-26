<?php
//삭제하기
session_start();
  $session_id = $_SESSION['session_id'];
  $newArray = array();

  $list = $_POST['movie_cancel_check'];

  $sidArray = array();
  $sidArray_num = array();
  //회원파일에서 삭제
  $file = fopen("../data/$session_id.json",'r');
  if ($file == null) return null;
  while (!feof($file)) {
      $line = trim(fgets($file));
      if ($line == null) {
          continue;
      }
      $movie = json_decode($line);
      $flag=0;
      for ($i=0; $i <count($list) ; $i++) {
        if($movie->id==$list[$i]){
          $flag=1;
          break;
        }
      }
      if($flag==1){
        array_push($sidArray, $movie->s_id);
        array_push($sidArray_num, $movie->reserve_num);
      }
      if($flag==0){
          array_push($newArray, $movie);
      }
  }
  fclose($file);

  $file = fopen("../data/$session_id.json", "w");
  for ($i=0; $i <count($newArray) ; $i++) {
    $encoded_newmovie = json_encode($newArray[$i], JSON_UNESCAPED_UNICODE);
    fwrite($file, $encoded_newmovie."\n");
  }
  fclose($file);

  //screening에서 예약수 변경
  $newMovie = array();
  $file = fopen("../data/screening.json",'r');
  if ($file == null) return null;
  while (!feof($file)) {
      $line = trim(fgets($file));
      if ($line == null) {
          continue;
      }
      $movie = json_decode($line);
      $flag=0;
      $nrseat = $movie->reserve_seat;
      for ($i=0; $i <count($sidArray) ; $i++) {
        if($sidArray[$i]==$movie->id){
          $flag=1;
          $nrseat-= $sidArray_num[$i];
        }
      }
      if($flag==1){
        $nmovie = new stdClass();
        $nmovie->id = $movie->id;
        $nmovie->date = $movie->date;
        $nmovie->movie_id = $movie->movie_id;
        $nmovie->screening_id = $movie->screening_id;
        $nmovie->reserve_seat  = $nrseat;
        array_push($newMovie, $nmovie);
      }
      if($flag==0){
        array_push($newMovie, $movie);
      }
  }
  fclose($file);

  $file = fopen("../data/screening.json", "w");
  for ($i=0; $i <count($newMovie) ; $i++) {
    $encoded_newmovie = json_encode($newMovie[$i], JSON_UNESCAPED_UNICODE);
    fwrite($file, $encoded_newmovie."\n");
  }
  fclose($file);
  echo "<script src = 'reserve_cancel.js'></script>";
 ?>
