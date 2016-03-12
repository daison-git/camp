<?php

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $body = $_POST['body'];
  $title = $_POST['title'];
  $errors = array();

  // バリデーション
  if ($title == '') {
    $errors['title'] = 'タイトルが未入力です';
  }

  if ($body == '') {
    $errors['body'] = '本文が未入力です';
  }

  // バリデーション突破後
  if (empty($errors)) {
    $dbh = connectDatabase();
    $sql = "insert into posts (body, title, created_at, updated_at) values
    (:body, :title, now(), now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":body", $body);
    $stmt->bindParam(":title", $title);
    $stmt->execute();

    header('Location: index.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規記事投稿</title>
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
      <div class="col-lg-12">
        <?php if ($success) : ?>
          <div class="alert alert-success">
            <strong><?php echo h($successMessage); ?></strong>
          </div>
        <?php endif; ?>
        <?php if ($errors) :  ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>
              <li style="color: red;">
                <?php echo h($error); ?>
              </li>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <h2>新規記事投稿</h2>
        <form action="" method="post">
          <div class="form-group">
            <label>タイトル</label>
            <input type="text" name="title" class="form-control" value="<?php echo h($title); ?>">
          </div>
          <div class="form-group">
            <label>本文</label>
            <textarea name="body" class="form-control" cols="30" rows="10"><?php echo h($body); ?></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="投稿" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>