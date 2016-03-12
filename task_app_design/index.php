<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
$dbh = connectDb();

$sql = "select * from tasks";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


// 新規タスク追加
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tag = $_POST['tag'];
    $title = $_POST['title'];
    $errors = array();

    // バリデーション
    if ($title == '') {
        $errors['title'] = 'タスク名を入力してください';
    }

    if ($tag == '') {
        $tag = '未分類';
    }

    if (empty($errors)) {
        $dbh = connectDb();
        $sql = "insert into tasks (tag, title, created_at, modified_at) values (:tag, :title, now(), now())";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":tag", $tag);
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
<title>Tasks!</title>
<!-- bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!-- <link rel="stylesheet" href="css/style.css"> -->
<link rel="stylesheet" media="(min-width: 690px)" href="css/style.css">
<link rel="stylesheet" media="(max-width: 689px)" href="css/style.css">
</head>
<body>
<div class="row">

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
        <a class="navbar-brand" href="./index.php">Tasks!</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        <ul class="nav navbar-nav navbar-right">

          <li><a href="">UserName</a></li>
          <li><img style="margin: 5px;" src="img/sun.png" height="40" width="40" alt=""></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

    <div class="container">
        <div class="col-lg-12">
            <div class="main">
                <form action="" method="post" class="form-inline">
                    <div class="form-group">
                        <input type="text" name="tag" placeholder="タグ" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="タスク名" maxlength="20">
                    </div>
                    <button type="submit" class="btn btn-default">追加</button>
                </form>
                <div class="board">
                    <p>現在のタスク</p>
                    <?php if ($tasks) : ?>
                        <?php foreach ($tasks as $task) : ?>
                            <?php if ($task['status'] == 'notyet') : ?>
                                <div class="card">
                                    <div class="tag">
                                        <?php echo h($task['tag']); ?>
                                    </div>
                                    <div class="content">
                                        <a href="done.php?id=<?php echo h($task['id']); ?>" class="btn-xs btn-primary">完了</a>
                                        <a href="delete.php?id=<?php echo h($task['id']); ?>" class="btn-xs btn-warning">ゴミ箱</a>
                                        <?php echo h(mb_substr($task['title'], 0, 20)); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="board">
                    <p>完了したタスク</p>
                    <?php foreach ($tasks as $task) : ?>
                        <?php if ($task['status'] == 'done') : ?>
                            <div class="card">
                                <div class="tag">
                                    <?php echo h($task['tag']); ?>
                                </div>
                                <div class="content" style="">
                                    <a href="reset.php?id=<?php echo h($task['id']); ?>" class="btn-xs btn-default">戻す</a>
                                    <a href="delete.php?id=<?php echo h($task['id']); ?>" class="btn-xs btn-warning">ゴミ箱</a>
                                    <?php echo h(mb_substr($task['title'], 0, 20)); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="board">
                    <p>ゴミ箱</p>
                    <?php foreach ($tasks as $task) : ?>
                        <?php if ($task['status'] == 'delete') : ?>
                            <div class="card">
                                <div class="tag">
                                    <?php echo h($task['tag']); ?>
                                </div>
                                <div class="content">
                                    <a href="reset.php?id=<?php echo h($task['id']); ?>" class="btn-xs btn-default">戻す</a>
                                    <a href="delete.php?id=<?php echo h($task['id']); ?>&flag=delete" class="btn-xs btn-danger">削除</a>
                                    <?php echo h(mb_substr($task['title'], 0, 20)); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>