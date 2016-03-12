<?php

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $body = $_POST['body'];
  $title = $_POST['title'];
  $errors = array();

  // バリデーション
  if ($title == '') {
    $errors['title'] = 'タイトルが未入力です';
  }

  if ($body == '') {
    $errors['body'] = 'メッセージが未入力です';
  }

  // バリデーション突破後
  if (empty($errors)) {
    $dbh = connectDatabase();
    $sql = "insert into posts set title = :title, body = :body, updated_at = now()";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":body", $body);
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
</head>
<body>
  <h1>新規記事投稿</h1>
  <p><a href="index.php">戻る</a></p>
  <?php if ($errors) : ?>
    <?php foreach ($errors as $error) : ?>
      <li>
        <?php echo h($error); ?>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      タイトル<br>
      <input type="text" name="title">
    </p>
    <p>
      本文<br>
      <textarea name="body" cols="30" rows="5"></textarea>
    </p>
    <p><input type="submit" value="投稿する"></p>
  </form>
</body>
</html>