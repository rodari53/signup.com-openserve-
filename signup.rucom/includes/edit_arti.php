<?php include_once "config.php"; 


$id= $_GET['id'];

$result= mysqli_query($dbc, "SELECT `id`, `title`, `image`, `text`, `categorie_id`, `pubdate` FROM `articles` WHERE id = '$id' " );

$row= mysqli_fetch_assoc($result);


if(isset($_POST['save_1']))
{
  $title = strip_tags(trim($_POST['name']));
  $jpg = strip_tags(trim($_POST['jpg']));
  $text = strip_tags(trim($_POST['text']));
  $cater = strip_tags(trim($_POST['cater']));


   mysqli_query($dbc, "UPDATE `articles` SET `title`= '$title', `image`= '$jpg', `text`= '$text', `categorie_id`= '$cater'  WHERE `id` ='$id' ");

    echo '<span style="color:green; font-weight: bold; margin-bottom:10px; display:block;">Данные сохранены!</span>';
    ?>

    <input type="submit" value="Вернуться" onclick=" location.href='../admin.php'  ">
    <hr><br>
    <?
}


?>

<html>
<head>
<title>Изменение категории</title>
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

<p style="text-align:center;"><strong>Добавить товар</strong></p><br>

<div class="block__content">
                      <form class="form" method="POST" action="edit_arti.php?id=<?php echo $id; ?>">

                        

                      <center> 
                          

                          	
                          
                        <div> <p>Название:</p>
                            <input type="text" name="name" size="30" " placeholder="Название товара" value="<?php echo $row['title']; ?>">
                          
                          
                           <p>Фотография:</p>
                            <input type="text" name="jpg" size="30" placeholder="Изображение" value="<?php echo $row['image']; ?>">
                          </div> 

                          <div><p>Описание:</p>
                           <textarea rows="5" cols="32" name="text" placeholder="<?php echo $row['text']; ?>"><?php echo $row['text']; ?> </textarea>
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
                           № <input type="text" name="cater" size="2" placeholder="1-<?php echo $cat['id']; ?>" value="<?php echo $row['categorie_id']; ?>">
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
            

          </table>   <br>                      
                      
                        <div class="form__group">
                          <input type="submit" name="save_1" value="Сохранить" class="form__control">

                        </div>

                      </form>

                      </div>


                    </center>
<br>
<hr>
<br>

            </body>
           
            </html>