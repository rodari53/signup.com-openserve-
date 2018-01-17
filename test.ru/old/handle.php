<?php


// $_GET
// $_POST


include('includes/db.php');

$login= $_POST['login'];
$password = $_POST['password'];


//echo "Ваш Логин: " . $_POST['login']. '<br>';
//echo "Ваш Пароль: ". $_POST['password'].'<br>';

$count = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password' "); 


if( mysqli_num_rows($count)== 0 )
{
echo 'Вы не зарегестрированы!';

} else
{
	echo 'Привет, ' . $login . '!';
}