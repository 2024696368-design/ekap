<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Club $club
 * @var array<string, string> $facultyOptions
 * @var array<string, string> $statusOptions
 */
$this->assign('title', 'Register New Club');
?>

<div class="page-heading">
    <div>
        <span class="badge-soft status-active mb-2">
            <i class="bi bi-people-fill me-1"></i><?= __('Club Management') ?>
        </span>
        <h1><?= __('Register New Club / Society') ?></h1>
        <p><?= __('Once activated, the club will appear automatically in student application forms.') ?></p>
    </div>

    <?= $this->Html->link(
        '<i class="bi bi-arrow-left"></i>' . __('Back to Clubs'),
        ['action' => 'index'],
        ['class' => 'button button-outline', 'escape' => false]
    ) ?>
</div>

<div class="content">
    <?= $this->Form->create($club) ?>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-building-add"></i>
            <div>
                <h3><?= __('Club Information') ?></h3>
                <p><?= __('Enter the official registration and advisor details.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <div class="full-width">
                <?= $this->Form->control('club_name', [
                    'label' => __('Club / Society Name'),
                    'required' => true,
                    'placeholder' => __('Example: Information Management Society'),
                ]) ?>
            </div>

            <?= $this->Form->control('registration_no', [
                'label' => __('Registration Number'),
                'required' => true,
                'placeholder' => __('Example: UITM-PP-CLUB-001'),
            ]) ?>

            <?= $this->Form->control('faculty', [
                'label' => __('Faculty'),
                'options' => $facultyOptions,
                'empty' => __('Select faculty'),
            ]) ?>

            <?= $this->Form->control('advisor_name', [
                'label' => __('Advisor Name'),
                'placeholder' => __('Enter advisor full name'),
            ]) ?>

            <?= $this->Form->control('advisor_email', [
                'type' => 'email',
                'label' => __('Advisor Email'),
                'placeholder' => 'advisor@uitm.edu.my',
            ]) ?>

            <?= $this->Form->control('status', [
                'label' => __('Status'),
                'options' => $statusOptions,
                'required' => true,
                'help' => __('Only active clubs appear in student application forms.'),
            ]) ?>
        </div>
    </div>

    <div class="form-actions">
        <?= $this->Form->button(
            '<i class="bi bi-check-circle"></i>' . __('Register Club'),
            ['escapeTitle' => false]
        ) ?>

        <?= $this->Html->link(
            __('Cancel'),
            ['action' => 'index'],
            ['class' => 'button button-outline']
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
