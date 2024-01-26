<?php
$loginid = $_POST["loginid"];
$loginpw = $_POST["loginpw"];

$user = new stdClass();
$user->id = $loginid;
$user->pw = $loginpw;

saveUser($user);

function saveUser($user) {
    $encoded_user = json_encode($user, JSON_UNESCAPED_UNICODE);
    $file = fopen("../data/person.json", "a");
    fwrite($file, $encoded_user . "\n");
    fclose($file);
}
echo "<script src = 'goto_search.js'></script>";
?>
