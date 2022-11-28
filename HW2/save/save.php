<?php
  echo '저장되었습니다.';
  $movie_name= test_input($_POST["title"]);
  $genre = test_input($_POST["genre"]);
  $director= test_input($_POST["director"]);
  $actors = $_POST["performer"];
  $file_name= test_input($_FILES["file_name"]["name"]);
  $date= test_input($_POST["movie_date"]);
  $theater_date = $_POST["theater_date"];

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

//movie.json에 저장
  $file = fopen("../data/movie.json", "r");
  $id=0;
  if ($file != null){
  while (!feof($file)) {
      $line = trim(fgets($file));
      if ($line == null) {
          continue;
      }
      $id++;
    }
  }
  fclose($file);
  $movie = new stdClass();
  $movie->id = 'm'.$id;
  $movie->movie_name = $movie_name;
  $movie->genre = $genre;
  $movie->director = $director;
  $movie->actors = $actors;
  $movie->file_name = $file_name;

  saveMovie($movie);
  function saveMovie($movie) {
      $encoded_movie = json_encode($movie, JSON_UNESCAPED_UNICODE);
      $file = fopen("../data/movie.json", "a");
      fwrite($file, $encoded_movie . "\n");
      fclose($file);
  }
//

//screening.json에 저장
  $sfile = fopen("../data/screening.json", "r");
  $sid=0;
  if ($sfile != null){
  while (!feof($sfile)) {
      $line = trim(fgets($sfile));
      if ($line == null) {
          continue;
      }
      $sid++;
    }
  }
fclose($sfile);
$sfile = fopen("../data/screening.json", "a");
  foreach ($theater_date as $key => $value) {
    $infoString = explode(",", $value);
    $smovie = new stdClass();
    $smovie->id = 'r'.$GLOBALS['sid'];
    $smovie->date = $infoString[0];
    $smovie->movie_id = 'm'.$id;
    $smovie->screening_id = $infoString[1];
    $smovie->reserve_seat = 0;
    $GLOBALS['sid']++;
    $encoded_smovie = json_encode($smovie, JSON_UNESCAPED_UNICODE);
    fwrite($sfile, $encoded_smovie."\n");
  }
fclose($sfile);
//

  //파일 업로드
  $target_dir = 'C:\Apache24\htdocs\school\HW2\uploads/';
  $target_file = $target_dir . $file_name;
  $uploadOk = 1;
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  if($uploadOk == 1){
    move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file);
  }

 ?>
