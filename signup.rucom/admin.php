
<?php 
  require "includes/config.php";
?>

<html>
<head>
<title>Админ панель</title>
<link href="style/style1.css" rel="stylesheet">
 <style>
   table {
    width: 80%; /* Ширина таблицы */
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   	text-align:center;
   }
   td, th {
    padding: 3px; /* Поля вокруг содержимого таблицы */
    border: 1px solid #000; /* Параметры рамки */
   }
   th {
    background: #C0C0C0; /* Цвет фона */
    color: #333;  /* Цвет текста */
   }
   tr:hover {
    background: #66CCCC; /* Цвет фона при наведении */
    color: #333333; /* Цвет текста при наведении */
   }
  </style>

 
</head>
<body>

<center><strong>Главная страница</strong></center>
<center><p>
		<input type="submit" value="Главная" onclick=" location.href='/'  "><br><br>
</p></center>






	<p style="text-align:center;"><strong>Список пользователей</strong></p><br>
<?php 
$categories_q= mysqli_query($dbc, "SELECT * FROM `users`");
    $categories = array();
    while ( $cat = mysqli_fetch_assoc($categories_q) )
    {
      $categories[] = $cat ;
    } 
          ?>		
           				<div><table style="margin: auto;" >
                  	<tr>
											<th>id</th>
											<th>Логин</th>
											<th>email</th>
                      <th style="width: 10%";>действие</th>
										</tr>
										

                <?php 
                foreach( $categories as $cat)
                {
                  ?> 


                 		<tr>
											<td><?php echo $cat['id']; ?></td>	
											<td><?php echo $cat['login']; ?></td>	
											<td><?php echo $cat['email']; ?></td>	
                      <td style="width: 10%";><a href="includes/delete_users.php?id=<?php echo $cat['id']; ?>">Удалить</a></td>
										</tr>
                 	
                       
                <?php
                }
              ?>
            </table></div>


<br><br>
<br><br>


<p style="text-align:center;"><strong>Список товаров</strong></p><br>
<?php 
$categories_q= mysqli_query($dbc, "SELECT * FROM `articles`");
    $categories = array();
    while ( $cat = mysqli_fetch_assoc($categories_q) )
    {
      $categories[] = $cat ;
    } 
          ?>		
           				<div><table style="margin: auto;" >
                  	
                   


                    <tr>
											<th>id</th>
											<th>Название</th>
											<th>Изображение</th>
											<th>Описание</th>
											<th>Категория</th>
											<th>дата публикации товара</th>
											<th>просмотры товара</th>
										</tr> 


                  
										

                <?php 
                foreach( $categories as $cat)
                {
                  ?> 
                 		<tr>
											<td><?php echo $cat['id']; ?></td>	
											<td><?php echo $cat['title']; ?></td>	
											<td><?php echo $cat['image']; ?></td>	
											<td><?php echo $cat['text']; ?></td>	
											<td><?php echo $cat['categorie_id']; ?></td>	
											<td><?php echo $cat['pubdate']; ?></td>	
											<td><?php echo $cat['views']; ?></td>	
										</tr>
                 	
                <?php
                }
              ?>
            </table></div>


<br><br>
<br><br>
  


<p style="text-align:center;"><strong>Список товаров по категориям</strong></p><br>

						<table style="margin: auto;" >
                  	<tr>
                  		<th>№ </th>
											<th>id - товара</th>
											<th>Название</th>
											<th>Изображение</th>
											<th>Описание</th>
											<th>Категория</th>
											<th>дата публикации товара</th>
											<th>просмотры товара</th>
                      <th>действие</th>
										</tr>
<?php  // добавление категорий по номеру
    $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories`");
    $categories = array();
    while ( $cat = mysqli_fetch_assoc($categories_q) )
    {
      $categories[] = $cat ;
    } 
          ?>


 <?php  
 									$i=1;
                  $articles = mysqli_query($dbc, "SELECT * FROM `articles` " ); //ORDER BY `categorie_id` DESC / ASC LIMIT 10
                        ?>

                  <?php 
                  while ( $art = mysqli_fetch_assoc($articles))
                  {
                    ?>
                  
                     <tr>

                     	<td><?php echo $i++ ?></td>
                     	<td><?php echo $art['id']; ?></td>
                    	<td>
                         <div class="holder">
                        <?php echo $art['title']; ?>
                        <div class="block">
<input type="submit"  style="font-size: 7pt;" value="Удалить" onclick=" location.href='includes/delete_arti.php?id=<?php echo $art['id']; ?>'  ">
<input type="submit"  style="font-size: 7pt;" value="Редактировать" onclick=" location.href='includes/edit_arti.php?id=<?php echo $art['id']; ?>'  ">
                          </div>
                          </div>
                      </td>
                      <td><?php echo $art['image']; ?></td>
                    	<td><?php echo $art['text']; ?></td>
                    
                          
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
                         
                          
                          


                        
                          <td><?php echo $art_cat['title']; ?></td>  
                         <td><?php echo $art['pubdate']; ?></td> 
                         <td><?php echo $art['views']; ?></td>
                         <td>
                          <a href="includes/delete_arti.php?id=<?php echo $art['id']; ?>">Удалить</a><br>
                          <a href="includes/edit_arti.php?id=<?php echo $art['id']; ?>">Редактировать</a>
  

                         </td> 
                             


                             
  

                         
                          </tr>

                    <?php

                  }
                    ?>

											
                  </table>





                     







<br><br>
<br><br>





































<p style="text-align:center;"><strong>Добавить товар</strong></p><br>

<div class="block__content">
                      <form class="form" method="POST" action="">

                        <?php 
                          if( isset($_POST['dobavit']) )
                            {
                                 $errors = array();

                               



                                  if (empty($errors))
                                  {
                                       // добавить коментарий

                                    mysqli_query($dbc, "INSERT INTO `articles` (`title`, `image`, `text`, `categorie_id`, `pubdate`) 
                                                               VALUES ('".$_POST['name']."', '".$_POST['jpg']."', '".$_POST['text']."',
                                                                 '".$_POST['cater']."' , NOW()  )");

                                     echo '<span style="color:green; font-weight: bold; margin-bottom:10px; display:block;">Коментарий успешно добавлен!</span>';
                                  } else 
                                  {
                                    //вывести ошибку
                                    echo '<span style="color:red; font-weight: bold; margin-bottom:10px; display:block;">' .  $errors['0'] .'<hr>'. '</span>';

                                  }
                              }
                              ?>

                      <center> 
                          

                          	
                          
                        <div> <p>Название:</p>
                            <input type="text" name="name" size="30" " placeholder="Название товара" value="<?php echo $_POST['name']; ?>">
                          </div> 
                          
                          <div> <p>Фотография:</p>
                            <input type="text" name="jpg" size="30" placeholder="Изображение" value="<?php echo $_POST['jpg']; ?>">
                          </div> 

                          <div><p>Описание:</p>
                           <textarea rows="5" cols="32" name="text" placeholder="Описание товара..."><?php echo $_POST['text']; ?></textarea>
                          </div> 



          <?php // (1-3)
            
          $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories` ORDER BY `id` DESC  LIMIT 1 ");
           $categories = array();
           while ( $cat = mysqli_fetch_assoc($categories_q) )
          {
            $categories[] = $cat ;
          } 
           ?>   
              <?php 
                foreach( $categories as $cat)
                {
                  ?> 



                           <div> <p>Категория:</p>
                           № <input type="text" name="cater" size="2" placeholder="1-<?php echo $cat['id']; ?>" value="<?php echo $_POST['jpg']; ?>">
                          </div>

             <?php
                }
              ?>




                          
                           <h3>Список категорий:</h3>

                            <table   style="width: 30%";>
                              <tr>
                                <th>Номер категории</th>
                                <th>Наименование</th>
                              </tr>

            <?php 
            $t=1;
          $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories` ");
           $categories = array();
           while ( $cat = mysqli_fetch_assoc($categories_q) )
          {
            $categories[] = $cat ;
          } 
           ?>   
              <?php 
                foreach( $categories as $cat)
                { 
                  ?> 
                  <tr>
                    <td> <strong> № <?php echo $t++ ; ?> </strong></td>
                    <td> <?php echo $cat['title']; ?></td>
                </tr>
                <?php
                }
              ?>
            

          </table>




													<p>
					<select name="cate">

				<?php 
					$categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories` ORDER BY `id` ASC  LIMIT 10");
   				 $categories = array();
   				 while ( $cat = mysqli_fetch_assoc($categories_q) )
    			{
    			  $categories[] = $cat ;
  			  } 
         	 ?>		
           		<?php 
                foreach( $categories as $cat)
                {
                  ?> 
                 		<option  value="r<?php echo $i++ ; ?>"><?php echo $cat['title']; ?></option>
                 	
                <?php
                }
              ?>
            </select></p>
                         
                      
                        <div class="form__group">
                          <input type="submit" name="dobavit" value="Добавить товар" class="form__control">
                        </div>

                      </form>
                      </div>
                    </center>
<br>
<hr>


  1- <?php 
            
          $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories` ORDER BY `id` DESC  LIMIT 1 ");
           $categories = array();
           while ( $cat = mysqli_fetch_assoc($categories_q) )
          {
            $categories[] = $cat ;
          } 
           ?>   
              <?php 
                foreach( $categories as $cat)
                {
                  ?> 
               <?php echo $cat['id']; ?>
                  
                <?php
                }
              ?>


<br><br>
<br><br>



<center><h3 style="text-align:center;"><strong>Добавить категорию</strong></h3><br>


  <h3>Список категорий:</h3>

                            <table   style="width: 30%";>
                              <tr>
                                <th>Номер категории</th>
                                <th>Наименование</th>
                                <th>Действие</th>
                              </tr>

            <?php 
            $t=1;
          $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories` ");
           $categories = array();
           while ( $cat = mysqli_fetch_assoc($categories_q) )
          {
            $categories[] = $cat ;
          } 
           ?>   
              <?php 
                foreach( $categories as $cat)
                { 
                  ?> 
                  <tr>
                    <td> <strong> № <?php echo $t++ ; ?> </strong></td>
                    <td> <?php echo $cat['title']; ?></td>
                    <td><a href="includes/delete_art_cat.php?id=<?php echo $cat['id']; ?>">Удалить</a></td>
                </tr>
                <?php
                }
              ?>
            

          </table></center>


<div class="block__content">
                      <form class="form" method="POST" action="">

                        <?php 
                          if( isset($_POST['dobavit_cat']) )
                            {
                                 $errors = array();

                               



                                  if (empty($errors))
                                  {
                                       // добавить коментарий

                                    mysqli_query($dbc, "INSERT INTO `articles_categories` (`id`, `title`) 
                                                               VALUES ('".$_POST['id_cat']."', '".$_POST['name_cat']."'  )");

                                     echo '<span style="color:green; font-weight: bold; margin-bottom:10px; display:block;">Коментарий успешно добавлен!</span>';
                                  } else 
                                  {
                                    //вывести ошибку
                                    echo '<span style="color:red; font-weight: bold; margin-bottom:10px; display:block;">' .  $errors['0'] .'<hr>'. '</span>';

                                  }
                              }
                              ?>

                      <center> 
                          
          <?php // (1-3)
            
            $th=1;
          $categories_q= mysqli_query($dbc, "SELECT * FROM `articles_categories` ORDER BY `id` DESC  LIMIT 1 ");
           $categories = array();
           while ( $cat = mysqli_fetch_assoc($categories_q) )
          {
            $categories[] = $cat ;
          } 
           ?>   
              <?php 
                foreach( $categories as $cat)
                {  $summ= $cat['id'] + $th
                  ?> 



                           <div> <p>ID категории:</p>
                           № <input type="text" name="id_cat" size="2" placeholder="" 
                           value="<?php echo ($cat['id'] + $th); ?>">
                          </div>

             <?php
                }
              ?>

                    <div> <p>Название категории:</p>
                            <input type="text" name="name_cat" size="30" " placeholder="Название категории" value="<?php echo $_POST['name_cut']; ?>">
                          </div> 
                         <br>
                      
                        <div class="form__group">
                          <input type="submit" name="dobavit_cat" value="Добавить категорию" class="form__control">
                        </div>

                      </form>
                      </div>
                    </center>








<br>
<hr>
<br>
<br>
<br>









</body>
</html>

