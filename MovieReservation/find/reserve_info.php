<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>예매 내역</title>
    <link rel="stylesheet" href="reserve_info.css">
  </head>
  <body>
    <div id="session_id_wrap">
      <div id="session_id_content">
      <?php
      session_start();
      if(isset($_SESSION['session_id'])){
        echo "<span id = 'session_id'>".$_SESSION['session_id']."</span>";
        echo "회원";
      }
      ?>
      </div>
    </div>

    <?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $session_id = $_SESSION['session_id'];

      echo "<form class='' action='movie_cancel.php' method='post'>";
      echo "<table>";
      echo "<tr><th>체크</th><th>예약 번호</th><th>영화 제목</th><th>상영 날짜</th><th>상영 장소</th><th>예매 수</th></tr>";

      $file = fopen("../data/$session_id.json",'r');
      if ($file == null) return null;
      while (!feof($file)) {
          $line = trim(fgets($file));
          if ($line == null) {
              continue;
          }
          $movie = json_decode($line);
          echo "<tr><td><input type='checkbox' name='movie_cancel_check[]' id='movie_cancel_check' value='$movie->id'></td><td>";
          echo $movie->id."</td><td>";

          $movie_title;
          $movie_date;
          $movie_location;
          //제목찾기
          $mfile = fopen("../data/movie.json",'r');
          if ($mfile == null) return null;
          while (!feof($mfile)) {
              $line2 = trim(fgets($mfile));
              if ($line2 == null) {
                  continue;
              }
              $movie2 = json_decode($line2);
              if($movie->movie_id==$movie2->id){
                $movie_title = $movie2->movie_name;
                break;
              }
          }
          fclose($mfile);
          //

          //상영날짜, 싱양징소 찾기
          $sfile = fopen("../data/screening.json",'r');
          if ($sfile == null) return null;
          while (!feof($sfile)) {
              $line3 = trim(fgets($sfile));
              if ($line3 == null) {
                  continue;
              }
              $movie3 = json_decode($line3);
              if($movie->s_id==$movie3->id){
                $movie_date = $movie3->date;
                $movie_location = $movie3->screening_id;
                break;
              }
          }
          fclose($sfile);
          //

          echo $movie_title."</td><td>";
          echo $movie_date."</td><td>";
          echo $movie_location."</td><td>";
          echo $movie->reserve_num."</td></tr>";
      }
      echo "</table>";
      echo "<button type='submit' name='movie_cancel_submit' id='movie_cancel_submit'>취소하기</button>";
      echo "</form>";
     ?>


  <script type="text/javascript" src = "./search.js"></script>
  </body>
</html>
