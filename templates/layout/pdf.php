<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title><?= h($this->fetch('title') ?: 'Surat Kelulusan EKAP') ?></title>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>