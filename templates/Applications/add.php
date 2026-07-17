<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 * @var array<int, string> $clubs
 * @var array<string, string> $organiserTypeOptions
 * @var array<string, string> $programLevelOptions
 * @var array<string, string> $programCategoryOptions
 */
$this->assign('title', 'New Application');
?>

<div class="page-heading">
    <div>
        <span class="badge-soft status-draft mb-2">
            <i class="bi bi-file-earmark-plus me-1"></i><?= __('New Draft') ?>
        </span>
        <h1><?= __('New Programme Application') ?></h1>
        <p><?= __('Complete the form below. You can save it as a draft before submitting it to HEP.') ?></p>
    </div>

    <?= $this->Html->link(
        '<i class="bi bi-arrow-left"></i>' . __('Back to Applications'),
        ['action' => 'index'],
        ['class' => 'button button-outline', 'escape' => false]
    ) ?>
</div>

<div class="content">
    <?= $this->Form->create($application) ?>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-people"></i>
            <div>
                <h3><?= __('Organiser Information') ?></h3>
                <p><?= __('Select the registered club or use Others when it is not listed.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <?= $this->Form->control('club_id', [
                'label' => __('Club / Society'),
                'options' => $clubs,
                'empty' => __('Select club or society'),
                'required' => true,
                'help' => __('New active clubs registered by HEP appear automatically. Select Others when needed.'),
            ]) ?>

            <?= $this->Form->control('organiser_type', [
                'label' => __('Organiser Type'),
                'options' => $organiserTypeOptions,
                'empty' => __('Select organiser type'),
                'required' => true,
            ]) ?>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-calendar-event"></i>
            <div>
                <h3><?= __('Programme Details') ?></h3>
                <p><?= __('Provide the core programme information, schedule and target audience.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <div class="full-width">
                <?= $this->Form->control('program_title', [
                    'label' => __('Programme Title'),
                    'required' => true,
                    'placeholder' => __('Enter the official programme title'),
                ]) ?>
            </div>

            <?= $this->Form->control('program_level', [
                'label' => __('Programme Level'),
                'options' => $programLevelOptions,
                'empty' => __('Select programme level'),
                'required' => true,
            ]) ?>

            <?= $this->Form->control('program_category', [
                'label' => __('Programme Category'),
                'options' => $programCategoryOptions,
                'empty' => __('Select programme category'),
                'required' => true,
            ]) ?>

            <?= $this->Form->control('venue', [
                'label' => __('Venue'),
                'required' => true,
                'placeholder' => __('Example: Seminar Hall 1'),
            ]) ?>

            <?= $this->Form->control('target_group', [
                'label' => __('Target Group'),
                'required' => true,
                'placeholder' => __('Example: UiTM students'),
            ]) ?>

            <?= $this->Form->control('start_datetime', [
                'label' => __('Start Date and Time'),
                'required' => true,
            ]) ?>

            <?= $this->Form->control('end_datetime', [
                'label' => __('End Date and Time'),
                'required' => true,
            ]) ?>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-person-count"></i>
            <div>
                <h3><?= __('Participation') ?></h3>
                <p><?= __('The total is calculated automatically.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <?= $this->Form->control('male_participants', [
                'type' => 'number',
                'label' => __('Male Participants'),
                'min' => 0,
                'id' => 'male-participants',
            ]) ?>

            <?= $this->Form->control('female_participants', [
                'type' => 'number',
                'label' => __('Female Participants'),
                'min' => 0,
                'id' => 'female-participants',
            ]) ?>

            <div class="full-width">
                <?= $this->Form->control('total_participants', [
                    'type' => 'number',
                    'label' => __('Total Participants'),
                    'readonly' => true,
                    'id' => 'total-participants',
                ]) ?>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-card-text"></i>
            <div>
                <h3><?= __('Programme Proposal') ?></h3>
                <p><?= __('Describe the programme purpose and expected benefits.') ?></p>
            </div>
        </div>

        <?= $this->Form->control('program_description', [
            'type' => 'textarea',
            'label' => __('Programme Description'),
            'required' => true,
            'rows' => 5,
        ]) ?>

        <?= $this->Form->control('objectives', [
            'type' => 'textarea',
            'label' => __('Objectives'),
            'required' => true,
            'rows' => 4,
        ]) ?>

        <?= $this->Form->control('expected_outcomes', [
            'type' => 'textarea',
            'label' => __('Expected Outcomes'),
            'rows' => 4,
        ]) ?>
    </div>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-cash-coin"></i>
            <div>
                <h3><?= __('Financial Information') ?></h3>
                <p><?= __('Enter the programme budget and requested allocation.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <?= $this->Form->control('estimated_budget', [
                'type' => 'number',
                'label' => __('Estimated Budget (RM)'),
                'min' => 0,
                'step' => '0.01',
            ]) ?>

            <?= $this->Form->control('requested_allocation', [
                'type' => 'number',
                'label' => __('Requested Allocation (RM)'),
                'min' => 0,
                'step' => '0.01',
            ]) ?>

            <div class="full-width">
                <?= $this->Form->control('funding_source', [
                    'label' => __('Funding Source'),
                    'placeholder' => __('Example: Student activity fund and sponsorship'),
                ]) ?>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-heading">
            <i class="bi bi-shield-exclamation"></i>
            <div>
                <h3><?= __('Risk and Person in Charge') ?></h3>
                <p><?= __('Record safety considerations and the responsible contact person.') ?></p>
            </div>
        </div>

        <div class="form-grid">
            <?= $this->Form->control('has_risk', [
                'label' => __('Does the programme involve risk?'),
            ]) ?>

            <?= $this->Form->control('risk_level', [
                'label' => __('Risk Level'),
                'options' => [
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ],
                'empty' => __('Select risk level'),
            ]) ?>

            <div class="full-width">
                <?= $this->Form->control('risk_description', [
                    'type' => 'textarea',
                    'label' => __('Risk Description'),
                    'rows' => 3,
                ]) ?>
            </div>

            <div class="full-width">
                <?= $this->Form->control('safety_action', [
                    'type' => 'textarea',
                    'label' => __('Safety Action'),
                    'rows' => 3,
                ]) ?>
            </div>

            <?= $this->Form->control('person_in_charge', [
                'label' => __('Person in Charge'),
                'required' => true,
            ]) ?>

            <?= $this->Form->control('pic_phone', [
                'label' => __('PIC Phone'),
                'required' => true,
            ]) ?>

            <div class="full-width">
                <?= $this->Form->control('pic_email', [
                    'type' => 'email',
                    'label' => __('PIC Email'),
                    'required' => true,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?= $this->Form->button(
            '<i class="bi bi-save"></i>' . __('Save as Draft'),
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
