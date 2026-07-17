<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Home');
?>

<div class="content text-center py-5">
    <?= $this->Html->image('ekap-logo-nav.png', [
        'alt' => 'e-KAP',
        'style' => 'width: 220px; max-width: 75%; height: auto;',
    ]) ?>

    <h1 class="mt-4 mb-2"><?= __('Welcome to e-KAP') ?></h1>
    <p class="mb-4"><?= __('Electronic Kelulusan Aktiviti Pelajar') ?></p>

    <?= $this->Html->link(
        '<i class="bi bi-house-door"></i>' . __('Open Dashboard'),
        '/dashboard',
        ['class' => 'button', 'escape' => false]
    ) ?>
</div>
