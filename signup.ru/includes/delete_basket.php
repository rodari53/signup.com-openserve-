<center><br><?php 

 include_once "config.php";


$id = $_GET['id'];

mysqli_query($dbc,"DELETE FROM `orders` WHERE id='$id' ");



echo 'Товар успешно удалена!';




	?><br><br>
	<input type="submit" value="Продолжить покупки" onclick=" location.href='../basket.php'  "><br><br> </center>


