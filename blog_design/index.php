<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDatabase();
$sql = "select * from posts order by updated_at desc";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>NOWALL Blog</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar navbar-inverse">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./index.php">NOWALL Blog</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="add.php">投稿する</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1>記事一覧</h1>
        <?php if (count($posts)) : ?>
          <?php foreach ($posts as $post) : ?>
            <h3><a href="show.php?id=<?php echo h($post['id']); ?>"><?php echo h($post['title']); ?></a></h3>
            <p><?php echo h(mb_substr($post['body'], 0, 50)); ?>...</p>
            <p>投稿日: <?php echo h($post['created_at']); ?></p>
            <hr>
          <?php endforeach; ?>
        <?php else : ?>
          投稿された記事はありません
        <?php endif; ?>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <img src="img/elites_logo.png">
          <div class="caption">
            <h3>株式会社NOWALL</h3>
            <p>Tel: 03-6279-0840</p>
            <p>Mail: info@nowall.co.jp</p>
          </div>
        </div>
        <div class="list-group">
          <?php if (count($posts)) : ?>
            <h3>最近の投稿</h3>
            <?php foreach ($posts as $post) : ?>
              <a href="show.php?id=<?php echo h($post['id']); ?>" class="list-group-item"><?php echo h($post['title']); ?></a>
            <?php endforeach; ?>
          <?php else : ?>
            投稿された記事はありません
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>