<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>영화 검색 페이지</title>
    <link rel="stylesheet" href="search.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>

  <!-- 로그인 창 -->
    <div id="pop-wrap">
      <div class="pop_content">
        <form method="POST" class = "pop_form">
          <p>
            <label for="loginid">id</label>
            <input type="text" id="loginid" name="loginid" value="" required>
          </p>
          <p>
            <label for="loginpw">password</label>
            <input type="password" id="loginpw" name="loginpw" value="" required>
          </p>
          <p>
            <label for=""></label>
            <button type="button" id="submitbutton" formmethod="post" formaction="./search_login.php">Submit</button>
            <button type="submit" id="signinbutton" formmethod="post" formaction="./search_makeid.php">SignIn</button>
          </p>
        </form>
      </div>
      <div class="pop_layer"></div>
    </div>

<!-- 영화 상영시간 정보 -->
    <div id="movie_date_wrap">
      <div id="date_pop_content" class="pop_content">
        <form class="" action="reserve.php" method="post">
          <span id = "date_pop_content_inner"></span>
          <button type='submit' name='reservation' id='reservation_submit'>예약</button>
          <button type='button' name='reservation_close' id='reservation_close'>닫기</button>
        </form>
      </div>

      <div class="pop_layer"></div>
    </div>


<!-- 로그인 프로필 정보 -->
    <div class="header_login">
      <?php
        session_start();
        if(isset($_SESSION['session_id'])){
          echo "<p id = 'session_id'>".$_SESSION['session_id']."</p>";
        }
       ?>
      <button type="button" id = "loginbutton" name="button">로그인</button>
      <form  method="POST">
        <button type="submit" id = "logoutbutton" formmethod="post" formaction="./search_logout.php">로그아웃</button>
      </form>
      <a href="" id = "reserve_go">예약정보</a>
    </div>

<!-- 영화 정보 -->
    <h1>영화 검색하기</h1>
    <form class="moviefind_form" action="search.php" method="post">
      <div class="moviefind_wrap">
      <input type="text" name="movie_find" value="">
      <br>
      <button type="submit" name="movie_find_button">영화 검색</button>
      </div>
    </form>

    <?php
      if(isset($_SESSION['session_id'])){
        echo "<script type='text/javascript' src = './when_login.js'></script>";
      }
     ?>
    <?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST['movie_find_button'])){

    $fmovie = test_input($_POST['movie_find']);
    echo "<form id='movie_find_form' action='' method='post'>";
    echo "<table>";
    echo "<tr><th>선택</th><th>영화 제목</th><th>장르</th><th>감독</th><th>배우</th><th>화일</th></tr>";

    $file = fopen("../data/movie.json", "r");
    if ($file == null) return null;
    // $movie_list = array();
    if($fmovie!==""){
    while (!feof($file)) {
        $line = trim(fgets($file));
        if ($line == null) {
            continue;
        }
        $movie = json_decode($line);
        $flag=0;
        foreach ($movie->actors as $key => $value) {
          if((strpos($movie->actors[$key], $fmovie)!==false)){
            $flag=1;
          }
        }
        if($flag==1||(strpos($movie->movie_name, $fmovie)!==false)||(strpos($movie->director, $fmovie)!==false)){
          echo "<tr><td><input type='radio' name='movie_check' value='$movie->id'></td><td>";
          echo $movie->movie_name."</td><td>";
          echo $movie->genre."</td><td>";
          echo $movie->director."</td><td>";
          foreach ($movie->actors as $key => $value) {
            if(count($movie->actors)-1==$key){
              echo $movie->actors[$key];
            }
            else{
              echo $movie->actors[$key].",";
            }
          }
          echo "</td><td>";
          echo "<a href='../uploads/$movie->file_name' target='_blank'>미리보기</a>"."</td></tr>";
        }
    }
  }
      echo "</table>";
      echo "<button type='button' name='find_theater_submit' id='find_theater_submit'>상영관 검색하기</button>";
    echo "</form>";
  }
    ?>

    <script type="text/javascript" src = "./search.js"></script>
  </body>
</html>
