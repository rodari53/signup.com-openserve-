<center><br><?php 

 include_once "config.php";


$id = $_GET['id'];

mysqli_query($dbc,"DELETE FROM `articles` WHERE id='$id' ");



echo 'Товар успешно удалена!';




	?><br><br>
	<input type="submit" value="Вернуться" onclick=" location.href='../admin.php'  "><br><br> </center>


