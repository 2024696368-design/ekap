<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array<string, string> $roleOptions
 * @var array<string, string> $facultyOptions
 */
$this->assign('title', 'Register');
?>

<section class="auth-stage" id="ekap-vanta">
    <div class="container-xl">
        <div class="register-card-wide">
            <div class="auth-card">
                <div class="page-heading">
                    <div>
                        <span class="badge-soft status-active mb-2">
                            <i class="bi bi-person-plus me-1"></i><?= __('New Account') ?>
                        </span>
                        <h1 class="h3 mb-2"><?= __('Register for e-KAP') ?></h1>
                        <p><?= __('Create a UiTM Puncak Perdana student or staff account.') ?></p>
                    </div>

                    <?= $this->Html->link(
                        '<i class="bi bi-arrow-left"></i>' . __('Back to Login'),
                        '/login',
                        [
                            'class' => 'button button-outline',
                            'escape' => false,
                        ]
                    ) ?>
                </div>

                <div class="role-note" id="admin-registration-note" hidden>
                    <i class="bi bi-shield-lock me-1"></i>
                    <?= __('A publicly registered Admin account remains inactive until an existing administrator activates it.') ?>
                </div>

                <?= $this->Form->create($user) ?>

                <div class="form-section">
                    <div class="form-section-heading">
                        <i class="bi bi-person-vcard"></i>
                        <div>
                            <h3><?= __('Account Information') ?></h3>
                            <p><?= __('Use accurate information for account verification.') ?></p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="full-width">
                            <?= $this->Form->control('full_name', [
                                'label' => __('Full Name'),
                                'required' => true,
                                'placeholder' => __('Enter your full name'),
                            ]) ?>
                        </div>

                        <?= $this->Form->control('email', [
                            'type' => 'email',
                            'label' => __('Email Address'),
                            'required' => true,
                            'autocomplete' => 'email',
                            'placeholder' => 'name@uitm.edu.my',
                        ]) ?>

                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'label' => __('Password'),
                            'required' => true,
                            'minlength' => 8,
                            'autocomplete' => 'new-password',
                            'help' => __('Use at least 8 characters.'),
                        ]) ?>

                        <?= $this->Form->control('role', [
                            'label' => __('Role'),
                            'options' => $roleOptions,
                            'empty' => __('Select role'),
                            'required' => true,
                            'id' => 'role',
                        ]) ?>

                        <?= $this->Form->control('faculty', [
                            'label' => __('Faculty'),
                            'options' => $facultyOptions,
                            'empty' => __('Select faculty'),
                            'required' => true,
                        ]) ?>

                        <div id="student-id-field" class="full-width">
                            <?= $this->Form->control('student_no', [
                                'label' => __('Student ID'),
                                'id' => 'student-no',
                                'placeholder' => __('Example: 2026123456'),
                            ]) ?>
                        </div>

                        <div id="staff-id-field" class="full-width" hidden>
                            <?= $this->Form->control('staff_no', [
                                'label' => __('Staff ID'),
                                'id' => 'staff-no',
                                'placeholder' => __('Enter staff ID'),
                            ]) ?>
                        </div>

                        <div class="full-width">
                            <?= $this->Form->control('phone', [
                                'label' => __('Phone Number'),
                                'placeholder' => __('Example: 0123456789'),
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <?= $this->Form->button(
                        '<i class="bi bi-check-circle"></i>' . __('Register Account'),
                        ['escapeTitle' => false]
                    ) ?>

                    <?= $this->Html->link(
                        __('Cancel'),
                        '/login',
                        ['class' => 'button button-outline']
                    ) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>
