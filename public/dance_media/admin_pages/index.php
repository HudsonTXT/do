<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>[DanceOnline] - админ-панель</title>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans&amp;subset=cyrillic" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" href="admin_pages/style.css">
  </head>
  <body>
    <div class="container">
      <p class="logo"><h1>DanceOnline!<br>Admin panel.</h1></p>
      <div class="left-side">
  <?
    $counters = $db->query("SELECT COUNT(DISTINCT u.id) AS users, COUNT(DISTINCT m.id) AS music, COUNT(DISTINCT l.id) AS logs FROM do_user u JOIN do_music m JOIN do_log l");
    $counters = $counters->fetch_assoc();
  ?>
    <div class="counters">
      <p><span>Пользователи:</span><?=$counters[users]?></p>
      <p><span>Песни:</span><?=$counters[music]?></p>
      <p><span>Танцы:</span><?=$counters[logs]?></p>
    </div>

      </div>
      <div class="right-side">
        <?
  if(empty($htmlContent)){
    ?><p class="alert def">Выберите необходимый пункт</p><?
  }

        ?>
      </div>
    </div>

  </body>
</html>
