<?php
// 로그인할수 있는지 확인
session_start();

$loginid= test_input($_POST["loginid"]);
$loginpw = test_input($_POST["loginpw"]);

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$ofile = fopen("../data/person.json", "r");
while(!feof($ofile)) {
  $value = trim(fgets($ofile));
  if ($value == null) {
    continue;
  }
  $user = json_decode($value);
  if($loginid===$user->id){
    if($loginpw===$user->pw){
      $_SESSION['session_id'] = $loginid;
      $_SESSION['session_pw'] = $loginpw;

      break;
    }
  }
}
header("Location: ./search.php");
fclose($ofile);
 ?>
