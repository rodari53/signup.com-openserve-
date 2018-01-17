<center><br><?php 

 include_once "config.php";


$id = $_GET['id'];

mysqli_query($dbc,"DELETE FROM `users` WHERE id='$id' ");



echo 'Пользователь успешно удален!';


	?>
	<br><br>
	<input type="submit" value="Вернуться" onclick=" location.href='../admin.php'  "><br><br> </center>



