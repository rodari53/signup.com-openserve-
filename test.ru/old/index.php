<?php

 $connection = mysqli_connect('127.0.0.1', 'root', '', 'test_db');
  
if( $connection == false)
{
  echo 'Не удалось подключиться к базе данных!<br>';
  echo mysqli_connect_error();
  exit();
  
}
  
$result = mysqli_query ($connection, "SELECT * FROM `articles_categories` ");
  
if(mysqli_num_rows($result) == 0 )
{
	echo " Категорий не найдено!";
} else 
{ ?>
		<ul>
			<?php
					while ( ($cat = mysqli_fetch_assoc($result)) )
					{

$articles_count= mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles` WHERE `categorie_id` = " . $cat['id']);

$articles_count_result= mysqli_fetch_assoc($articles_count);


						echo '<li>' . $cat['title']. ' ('.$articles_count_result['total_count'] .')</li>';
					}

			?>

			</ul>

<?php
}


?>


	<form method="POST" action="handle.php"> 
		<input type="text" placeholder="Ваш логин" name="login">
		<input type="text" placeholder="Ваш пароль" name="password">
		<hr>
		<input type="submit" value="Отправить">


	</form>






<?php
echo "<br>";echo "<br>";

echo date('d.m.Y H:i:s');

echo "<br>";echo "<br>";

$start_date = '2017-12-10 14:00:00';
$start_date_timestamp = strtotime($start_date);

$diff = time() - $start_date_timestamp;
$day_passed = floor ( (($diff / 60) /60 ) /24 );

echo 'Между '. date('d.m.Y H:i:s', $start_date_timestamp) . ' и ' . date('d.m.Y H:i:s'). ' прошло ' .
$day_passed . ' дня!';



mysqli_close($connection);

?>