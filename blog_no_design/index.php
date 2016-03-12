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
  <title>Blog</title>
</head>
<body>
  <h1>Blog</h1>
  <a href="add.php">新規記事投稿</a>
  <h1>記事一覧</h1>
  <?php if (count($posts)) : ?>
    <?php foreach ($posts as $post) : ?>
      <li style="list-style-type: none;">
        <a href="show.php?id=<?php echo h($post['id']) ?>"><?php echo h($post['title']) ?></a><br>
        <?php echo h($post['body']) ?><br>
        投稿日時: <?php echo h($post['updated_at']) ?>
        <hr>
      </li>
    <?php endforeach; ?>
  <?php else : ?>
    投稿された記事はありません
  <?php endif; ?>
</body>
</html>