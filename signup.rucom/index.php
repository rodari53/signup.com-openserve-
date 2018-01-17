<?php 
  require "includes/config.php";

if(!isset($_COOKIE['id'])) {
	if(isset($_POST['submit'])) {
		$user_username = mysqli_real_escape_string($dbc, trim($_POST['login']));
		$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
		if(!empty($user_username) && !empty($user_password)) {
			$query = "SELECT `id` , `login` FROM `users` WHERE login = '$user_username' AND password = SHA('$user_password')";
			$data = mysqli_query($dbc,$query);
			if(mysqli_num_rows($data) == 1) {
				$row = mysqli_fetch_assoc($data);
				

				setcookie('id', $row['id'], time() + (60*60*24*30));
				setcookie('login', $row['login'], time() + (60*60*24*30));
				$home_url = 'http://' . $_SERVER['HTTP_HOST'];
				header('Location: '. $home_url);
			}
			else {
				$error1='Неверные  данные!';
			} 
		} 
		else { 
			$error2='Заполните поля!';
		} 
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="style/style.css" rel="stylesheet">
</head>
<body>
<header>
<ul>

	<li><a href="/">Главная</a></li>
	<li><a href="/">Новости</a></li>
	<li><a href="/">Музыка</a></li>
	<li><a href="/">Обратная связь</a></li>
</ul>
</header>
<content>
	<div class="articles">
		<img src="images/2.jpg">
		<h2>Название статьи 1</h2>
		<p>Написание символов на сайтах и зла средневековый книгопечатник вырвал отдельные. Самым известным рыбным текстом является знаменитый lorem некоторые вопросы. Нечитабельность текста исключительно демонстрационная, то и т.д текстом является знаменитый lorem этот.</p>
		<a href="/">Читать полностью</a>
	</div>
	<div class="articles">
		<img src="images/2.jpg">
		<h2>Название статьи 2</h2>
		<p>Написание символов на сайтах и зла средневековый книгопечатник вырвал отдельные. Самым известным рыбным текстом является знаменитый lorem некоторые вопросы. Нечитабельность текста исключительно демонстрационная, то и т.д текстом является знаменитый lorem этот.</p>
		<a href="/">Читать полностью</a>
	</div>
	<div class="articles">
		<img src="images/2.jpg">
		<h2>Название статьи 3</h2>
		<p>Написание символов на сайтах и зла средневековый книгопечатник вырвал отдельные. Самым известным рыбным текстом является знаменитый lorem некоторые вопросы. Нечитабельность текста исключительно демонстрационная, то и т.д текстом является знаменитый lorem этот.</p>
		<a href="/">Читать полностью</a>
	</div>
	<div class="articles">
		<img src="images/2.jpg">
		<h2>Название статьи 4</h2>
		<p>Написание символов на сайтах и зла средневековый книгопечатник вырвал отдельные. Самым известным рыбным текстом является знаменитый lorem некоторые вопросы. Нечитабельность текста исключительно демонстрационная, то и т.д текстом является знаменитый lorem этот.</p>
		<a href="/">Читать полностью</a>
	</div>

</content>
<section>
<?php
	if(empty($_COOKIE['login'])) {
?>


	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<label for="login">Логин:</label>
	<input type="text" name="login">
	<label for="password">Пароль:</label>
	<input type="password" name="password">
	<button type="submit" name="submit">Вход</button>
	<a href="signup.php">Регистрация</a>
	</form>
<?php
}
else {
	?>
	<p><a href="myprofile.php">Мой профиль</a></p>
	<p><a href="exit.php">Выйти(<?php echo $_COOKIE['login']; ?>)</a></p>
<?php	
}
?>
</section>

<? echo $error1; ?>
<? echo $error2; ?>


<footer class="clear">
	<p>Все права защищены</p>
	<a href="admin.php">Панель администратора</a>
</footer>

</body>

</html>