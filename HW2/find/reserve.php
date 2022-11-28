<?php
//예매를 위해 validation
session_start();
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $rid =  test_input($_POST['movie_final_check']);
  $rseat = test_input($_POST['reserve_number']);

if(isset($_SESSION['session_id'])){

  if((int)$rseat>10){
    echo "<script src = 'up_ten.js'></script>";
    return;
  }

  $newArray = array();

  $user = new stdClass();
  $session_id = $_SESSION['session_id'];
  $ufile = fopen("../data/$session_id.json",'r');
  $id=0;
  if ($ufile != null){
  while (!feof($ufile)) {
      $line = trim(fgets($ufile));
      if ($line == null) {
          continue;
      }
      $id++;
  }
  }
  fclose($ufile);

  $file = fopen("../data/screening.json", "r");
  if ($file == null) return null;
  while (!feof($file)) {
      $newmovie = new stdClass();
      $line = trim(fgets($file));
      if ($line == null) {
          continue;
      }
      $movie = json_decode($line);
      if($movie->id==$rid){
        if($movie->reserve_seat+(int)$rseat>20){
          echo "<script src = 'up_twenty.js'></script>";
          return;
        }
        else{
            $user->id = 'u'.$id;
            $user->movie_id = $movie->movie_id;
            $user->s_id = $movie->id;
            $user->reserve_num = $rseat;

            $newmovie->id = $movie->id;
            $newmovie->date = $movie->date;
            $newmovie->movie_id = $movie->movie_id;
            $newmovie->screening_id = $movie->screening_id;
            $newmovie->reserve_seat = $movie->reserve_seat + (int)$rseat;
        }
      }
      else{
        $newmovie->id = $movie->id;
        $newmovie->date = $movie->date;
        $newmovie->movie_id = $movie->movie_id;
        $newmovie->screening_id = $movie->screening_id;
        $newmovie->reserve_seat = $movie->reserve_seat;
      }
      array_push($newArray, $newmovie);
  }
  fclose($file);

  $ufile = fopen("../data/$session_id.json",'a');
  $encoded_user = json_encode($user, JSON_UNESCAPED_UNICODE);
  fwrite($ufile, $encoded_user . "\n");
  fclose($ufile);

  $file = fopen("../data/screening.json", "w");
  for ($i=0; $i <count($newArray) ; $i++) {
    $encoded_newmovie = json_encode($newArray[$i], JSON_UNESCAPED_UNICODE);
    fwrite($file, $encoded_newmovie."\n");
  }
  fclose($file);
  echo "<script src = 'alert_reserve.js'></script>";
}else{
  echo "<script src = 'alert_login.js'></script>";
}
echo "<script src = 'goto_search.js'></script>";
 ?>
