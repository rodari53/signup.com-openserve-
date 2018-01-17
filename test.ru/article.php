<?php 
  require "includes/config.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Блог IT_Минималиста!</title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

  <div id="wrapper">

     <?php include "includes/head.php"; ?>


    <?php 
        $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id'] );

        if (mysqli_num_rows($article) <=0 )
        {
          ?>
               <div id="content">
               <div class="container">
              <div class="row">
                <section class="content__left col-md-8">
                  <div class="block">
                    
                    <h3>Статья не найдена!</h3>
                    <div class="block__content">
                      <div class="full-text">
                  Запрашиваемая вами статья не существует!
                      </div>
                    </div>
                  </div>


                </section>
                <section class="content__right col-md-4">
                  
                <?php include "includes/sidebar.php"; ?>

               </section>
              </div>
               </div>
               </div>
          <?php
        } else
        {
          $art = mysqli_fetch_assoc($article);
          mysqli_query($connection,"UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int) $art['id']);
          ?>
                <div id="content">
                   <div class="container">
                  <div class="row">
                    <section class="content__left col-md-8">
                      <div class="block">
                        <a><?php echo $art['views'] ?> просмотров </a>
                        <h3><?php echo $art['title']; ?></h3>
                        <div class="block__content">
                          <img src="/static/images/<?php echo $art['image'] ?>" style="max-width: 100%;">
                          <div class="full-text">
                            <br>
                      <?php echo $art['text']; ?>
                          </div>
                        </div>
                      </div>
                     

                                  <div class="block">
                                    <a href="#coment-add-form">Добавить свой</a>
                                          <h3>Комментарии</h3>
                                          <div class="block__content">
                                            <div class="articles articles__vertical">

                                             <?php  
           $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE  `articles_id` = " . (int) $art['id'] . " ORDER BY `id` DESC");
                                                   
                                              if(mysqli_num_rows($comments) <=0 )
                                              {
                                                echo "Нет Комментариев!";
                                              }
                                              
                                              while($comment = mysqli_fetch_assoc($comments) )
                                              {
                                                ?>
                                                 <article class="article">
                                                <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>"></div>
                                                <div class="article__info">
                                                  <a href="/article.php?id=<?php echo $comment['articles_id'];  ?>"><?php echo $comment['author'];  ?></a>
                                                  <div class="article__info__meta"></div>
                                                    <div class="article__info__preview">
                                                        <?php
                                                         echo $comment['text']; ?>
                                                      
                                                    </div>
                                                </div>
                                              </article>

                                                <?php

                                              }
                                                ?>

                                            </div>
                                          </div>
                                        </div>


                                        <p>fff</p>
                          





                    <div id="comment-add-form" class="block"> 
                      <h3>Добавить коментарий</h3>
                      <div class="block__content">
                      <form class="form" method="POST" action="">

                        <?php 
                          if( isset($_POST['do_post']) )
                            {
                                 $errors = array();

                                if( $_POST['name'] == '' )
                                  {      
                                      $errors[] = 'Введите Имя!';

                                  }
                                  if( $_POST['nickname'] == '' )
                                  { 
                                      $errors[] = 'Введите ваш никнэйм!';

                                  }
                                  if( $_POST['email'] == '' )
                                  { 
                                      $errors[] = 'Введите ваш email!';

                                  }
                                  if( $_POST['text'] == '' )
                                  { 
                                      $errors[] = 'Введите текст коментария!';

                                  }



                                  if (empty($errors))
                                  {
                                       // добавить коментарий

                                    mysqli_query($connection, "INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `pabdate`, `articles_id`) 
                                                               VALUES ('".$_POST['name']."', '".$_POST['nickname']."', '".$_POST['email']."',
                                                                '".$_POST['text']."', NOW() , '".$art['id']."')");

                                     echo '<span style="color:green; font-weight: bold; margin-bottom:10px; display:block;">Коментарий успешно добавлен!</span>';
                                  } else 
                                  {
                                    //вывести ошибку
                                    echo '<span style="color:red; font-weight: bold; margin-bottom:10px; display:block;">' .  $errors['0'] .'<hr>'. '</span>';

                                  }
                              }
                              ?>

                        <div class="form__group">
                          <div class="row">
                          <div class="col-md-4"> 
                            <input type="text" name="name" class="form__control" placeholder="Имя" value="<?php echo $_POST['name']; ?>">
                          </div>
                          <div class="col-md-4"> 
                            <input type="text" name="nickname" class="form__control" placeholder="Никнэйм" value="<?php echo $_POST['nickname']; ?>">
                          </div>
                          <div class="col-md-4"> 
                            <input type="text" name="email" class="form__control" placeholder="Email (не будет показан)" value="<?php echo $_POST['email']; ?>">
                          </div>
                        </div>
                      </div>
                        <div class="form__group">
                          <textarea class="form__control" name="text" placeholder="Текст коментариев ..."><?php echo $_POST['text']; ?></textarea>
                        </div>
                        <div class="form__group">
                          <input type="submit" name="do_post" value="Добавить коментарии" class="form__control">
                        </div>
                      </form>
                      </div>
                    </div>



                       


                    </section>
                    <section class="content__right col-md-4">
                      
                    <?php include "includes/sidebar.php"; ?>

                   </section>
                 </div>
             </div>
           </div>

          <?php

        }
    ?>

    <?php include "includes/footer.php"; ?>

  </div>

</body>
</html>