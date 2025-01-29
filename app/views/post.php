<!-- /views/post.php -->
<!DOCTYPE html>
<html>

<head>
    <title> <?= htmlspecialchars($post['title']) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><?= htmlspecialchars($post['content']) ?></p>
</body>

</html>