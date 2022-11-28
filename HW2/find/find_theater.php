<?php
// 상영 날짜와 상영관을 선택
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

  $cmovie = test_input($_POST['movie_check']);
  echo "<form class='' action='reserve.php' method='post'>";
  echo "<table>";
  echo "<tr><th>선택</th><th>상영 날짜</th><th>상영관</th><th>예약수</th></tr>";

  $file = fopen("../data/screening.json", "r");
  if ($file == null) return null;
  while (!feof($file)) {
      $line = trim(fgets($file));
      if ($line == null) {
          continue;
      }
      $movie = json_decode($line);
      if($movie->movie_id==$cmovie){
        echo "<tr><td><input type='radio' name='movie_final_check' id='movie_final_check' value='$movie->id'></td><td>";
        echo $movie->date."</td><td>";
        echo $movie->screening_id."</td><td id = 'reserve_number'>";
        echo $movie->reserve_seat."</td></tr>";
      }
  }
  echo "</table>";
  echo "예약할 인원: <input type='text' name='reserve_number' value=''><br>";
  echo "</form>";
 ?>
