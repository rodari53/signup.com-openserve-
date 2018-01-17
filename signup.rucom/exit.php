<?php
unset($_COOKIE['id']);
unset($_COOKIE['login']);
setcookie('id', '', -1, '/');
setcookie('login', '', -1, '/');
$home_url = 'http://' . $_SERVER['HTTP_HOST'];
 header('Location: ' . $home_url);
?>