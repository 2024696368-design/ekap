<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Club $club
 * @var array<string, string> $facultyOptions
 * @var array<string, string> $statusOptions
 */
$this->assign('title', 'Edit Club');
?>

<div class="page-heading">
    <div>
        <span class="badge-soft status-active mb-2">
            <i class="bi bi-pencil-square me-1"></i><?= __('Club Management') ?>
        </span>
        <h1><?= __('Edit Club / Society') ?></h1>
        <p><?= h($club->club_name) ?></p>
    </div>

    <div class="page-actions">
        <?= $this->Html->link(
            '<i class="bi bi-eye"></i>' . __('View Club'),
            ['action' => 'view', $club->id],
            ['class' => 'button button-outline', 'escape' => false]
        ) ?>
        <?= $this->Html->link(
            '<i class="bi bi-arrow-left"></i>' . __('Back to Clubs'),
            ['action' => 'index'],
            ['class' => 'button button-outline', 'escape' => false]
        ) ?>
    </div>
</div>

<div class="content">
    <?= $this->Form->create($club) ?>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-building-gear"></i>
            <div>
                <h3><?= __('Club Information') ?></h3>
                <p><?= __('Update official registration and advisor details.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <div class="full-width">
                <?= $this->Form->control('club_name', [
                    'label' => __('Club / Society Name'),
                    'required' => true,
                ]) ?>
            </div>

            <?= $this->Form->control('registration_no', [
                'label' => __('Registration Number'),
                'required' => true,
            ]) ?>

            <?= $this->Form->control('faculty', [
                'label' => __('Faculty'),
                'options' => $facultyOptions,
                'empty' => __('Select faculty'),
            ]) ?>

            <?= $this->Form->control('advisor_name', [
                'label' => __('Advisor Name'),
            ]) ?>

            <?= $this->Form->control('advisor_email', [
                'type' => 'email',
                'label' => __('Advisor Email'),
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
            '<i class="bi bi-save"></i>' . __('Save Changes'),
            ['escapeTitle' => false]
        ) ?>

        <?= $this->Html->link(
            __('Cancel'),
            ['action' => 'view', $club->id],
            ['class' => 'button button-outline']
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
