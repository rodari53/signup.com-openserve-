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
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<header>
<ul>

	<li><a href="/" style="color:black;">Главная</a></li>
	<li><a href="/" style="color:black;">Новости</a></li>
	<li><a href="/" style="color:black;">Обратная связь</a></li>
	
</ul>

</header>
<content>

<div class="block"><p><strong>Список товаров:</strong></p><br>
             <?php  
    $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories`");
    $categories = array();
    while ( $cat = mysqli_fetch_assoc($categories_q) )
    {
      $categories[] = $cat ;
    } 
          ?>

                      <?php  


                      $per_page = 4;
                     	$page= 1;
                      
                      if( isset($_GET['page']) )
                      {
                      	$page= (int) $_GET['page'];
                      }

                      $total_count_q= mysqli_query($dbc, "SELECT COUNT('id') AS `total_count` FROM `articles` ");
                      $total_count = mysqli_fetch_assoc($total_count_q);
                      $total_count = $total_count['total_count'];


                      $total_pages = ceil($total_count / $per_page);
                      if( $page <=1 || $page >$total_pages)
                      {
                      	$page= 1;
                      }

                      $offset= ($per_page * $page ) - $per_page;

                  $articles = mysqli_query($dbc, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT $offset, $per_page" );
                    
                    $articles_exist= true;
                   if (mysqli_num_rows($articles) <= 0) 
                   { 
                   		echo 'Нет статей.';
                   		$articles_exist=false;
                   	}    

                  while ( $art = mysqli_fetch_assoc($articles))
                  {
                    ?>
                  
     <div class="articles">
    <img style="max-height: 100%; max-width: 100%;" src="images/<?php echo $art['image']; ?>">
    <h2><?php echo $art['title'];  ?></h2>
      <p>
      <?php
       echo mb_substr(strip_tags($art['text']), 0, 100 , 'utf-8') . ' ...';
       ?>
      </p>

      <?php
    $art_cat= false;
    foreach ($categories as $cat)
    {
      if( $cat['id'] == $art ['categorie_id'] )
      {
        $art_cat = $cat;
        break;
      }
    }
    ?>
    
    

    <p><small>
    Категория: <a href="/articles.php?categorie=<?php echo $art_cat['id']; ?>"><?php echo $art_cat['title'];  ?></a>
    </small></p>
    <br>
    
    <?php
    if(empty($_COOKIE['login'])) {
    ?>
    <?php
    }
    else {
    ?>
    <div class="knopka"><p><a href="/">добавить в корзину</a></p></div>
    <?php 
    }
    ?>
    <div class="knopka-2"><p><a href="/">Карточка товара</a></p></div>
   
                    </div>
                  
                    <?php
                  }
                    ?>
                  
                    
                </div>
                <div>

								<?php 
								if ( $articles_exist == true )
                  {
                  	echo '<div class="paginator">';
                  	if ($page > 1 )
                  	{
                  		echo '<a href="/index.php?page='.($page - 1).'">&laquo; Предыдущая страница</a>                         ';
                  	}
                  	if ($page < $total_pages )
                  	{
                  		echo '<a href="/index.php?page='.($page + 1).'">  Следующая страница &raquo;</a>';
                  	}
                  	echo '</div>';
                  }
                    ?>
               </div>
               <br><br>

          






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
  <div class='r_menu'>
  
  <p>  Приветствуем вас, <?php echo $_COOKIE['login']; ?>!</p>
	<p><a href="myprofile.php">Мой профиль</a></p>
  <p><a href="basket.php">Корзина</a></p>
	<p><a href="exit.php">Выйти из профиля</a></p>
  </div>

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