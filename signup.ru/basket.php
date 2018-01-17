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
<link href="css/style_table.css" rel="stylesheet">
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


<div class="block">

  <p><strong></strong></p><br>
             

<h3><p style="text-align:center;">Моя корзина:</p></h3><br>
<div class="wrapper">
            <table style="margin: auto;" >
                    <tr>
                      
                      <th>№ товара</th>
                      <th>Наименование товара</th>
                      <th>Действие</th>
                      
                    </tr>
<?php  // добавление категорий по номеру
    $categories_q= mysqli_query($dbc, "SELECT * FROM `articles`");
    $categories = array();
    while ( $cat = mysqli_fetch_assoc($categories_q) )
    {
      $categories[] = $cat ;
    } 
          ?>


                  <?php  
                  $i=1;
                  $articles = mysqli_query($dbc, "SELECT * FROM `orders` " ); //ORDER BY `categorie_id` DESC / ASC LIMIT 10
                        ?>

                  <?php 
                  while ( $art = mysqli_fetch_assoc($articles))
                  {
                    ?>
                  
                     <tr>

                      
                      
                       <?php
                          $art_cat= false;
                          foreach ($categories as $cat)
                          {
                            if( $cat['id'] == $art ['id_product'] )
                            {
                              $art_cat = $cat;
                              break;
                            }
                          }
                          ?>
                           <td><?php echo $art['id']; ?></td>                       
                          <td><?php echo $art_cat['title']; ?></td> 
                           

                         <td>
                           <div class="holder">
                        <?php echo $art['id_product']; ?>  
                        <div class="block">
<input type="submit"  style="font-size: 7pt;" value="Удалить" onclick=" location.href='includes/delete_basket.php?id=<?php echo $art['id']; ?>'  ">
                          </div>
                          </div>
                         </td> 
  
                          </tr>
                    <?php
                  }   
                    ?>
                     
                  </table>



                </div><br>

<div class='добавление инфы'>

  <h4><p style="text-align:center;">Для оформления заказа добавьте данные:</p></h4><br><br>

<div class="block__content">
                      <form class="form" method="POST" action="">

                   <?php




                        $arr = array();
                         
                        $q = "SELECT * FROM `articles` ";
                        $r = mysqli_query($dbc,$q);
                         
                        if (mysqli_num_rows($r) > 0) {
                            while ($l = mysqli_fetch_array($r)) {
                                 $old = $l['title'];
                                 $arr[] = $old;
                            }
                        }
                         
                       $user_r = $_COOKIE['login'];
                        $id_orders=  $art['id_product'];


                          if( isset($_POST['zakaz']) )
                            {
                                 $errors = array();

                               



                                  if (empty($errors))
                                  {
                                       // добавить коментарий

                             mysqli_query($dbc, "INSERT INTO `orders_final` (`login`, `adress`, `id_orders`, `tel`, `sum`) 
                                                               VALUES ('".$user_r."', '".$_POST['jpg']."', '".$arr."',
                                                                 '".$_POST['cater']."' , NOW()  )");
                                    
                                                 
                                     
                                  } else 
                                  {
                                    //вывести ошибку
                                    echo '<span style="color:red; font-weight: bold; margin-bottom:10px; display:block;">' .  $errors['0'] .'<hr>'. '</span>';

                                  }
                              }
                              ?>

                      <center> 
                          

                       <?php echo $old  ?>
                          <div> <p>Адрес:</p><br>
                            <input type="text" name="name" size="30" " placeholder="Адрес заказа" value="">
                          </div> <br>  
                           <div> <p>Адрес:</p><br>
                            <input type="text" name="jpg" size="30" " placeholder="Адрес заказа" value="">
                          </div> <br>   
                           <div> <p>Адрес:</p><br>
                            <input type="text" name="text" size="30" " placeholder="Адрес заказа" value="">
                          </div> <br>   
                           <div> <p>Адрес:</p><br>
                            <input type="text" name="cater" size="30" " placeholder="Адрес заказа" value="">
                          </div> <br>    
                         



                        <div> <p>Номер телефона:</p><br>
                            <input type="text" name="tel" size="30" " placeholder="Адрес заказа" value="">
                          </div> <br>
                          
                          

                         <br> <div class="form__group">
                          <input type="submit"  name="zakaz" value="Заказать" class="form__control">
                        </div>

                      </form>
                      </div>
                    </center>

</div>







/еще проба
  <?php
$arr = array();
 
$q = "SELECT * FROM `orders` ";
$r = mysqli_query($dbc,$q);
 
if (mysqli_num_rows($r) > 0) {
    while ($l = mysqli_fetch_array($r)) {
         $old = $l['id_product'];
         $arr[] = $old;
    }
}
 ?>
   <?php print $arr; ?>   










  






 



































































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
  
    <p><a>  Вы вошли под логином: <strong><?php echo $_COOKIE['login']; ?></strong>!</a></p>
  <p><a href="/" ">Главная</a></p>
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