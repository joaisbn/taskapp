<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
</head>

<body>
    <?php if (session()->has('warning')) : ?>
        <?= session('warning') ?>
    <?php endif ?>

    <?php if (session()->has('info')) : ?>
        <?= session('info') ?>
    <?php endif ?>

    <?= $this->renderSection('content') ?>
</body>

</html>