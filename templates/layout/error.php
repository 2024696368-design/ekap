<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!doctype html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h((string)$this->fetch('title')) ?> | e-KAP</title>
    <?= $this->Html->meta('icon', '/img/ekap-logo-nav.png') ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?= $this->Html->css('ekap') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <nav class="navbar ekap-navbar">
        <div class="container-xl">
            <a class="navbar-brand ekap-brand" href="<?= h($this->Url->build('/dashboard')) ?>">
                <?= $this->Html->image('ekap-logo-nav.png', [
                    'alt' => 'e-KAP',
                    'class' => 'ekap-brand-logo',
                ]) ?>
                <span class="ekap-brand-copy">
                    <strong>e-KAP</strong>
                    <small>Electronic Kelulusan Aktiviti Pelajar</small>
                </span>
            </a>
        </div>
    </nav>

    <main class="app-main">
        <div class="container-xl py-5">
            <div class="content mx-auto" style="max-width: 760px;">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
                <div class="mt-4">
                    <?= $this->Html->link(
                        __('Back'),
                        'javascript:history.back()',
                        ['class' => 'button button-outline']
                    ) ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
