<center><br><?php 

 include_once "config.php";


$id = $_GET['id'];

mysqli_query($dbc,"DELETE FROM `articles_categories` WHERE id='$id' ");



echo 'Категория успешно удалена!';




	?><br><br>
	<input type="submit" value="Вернуться" onclick=" location.href='../admin.php'  "><br><br> </center>


