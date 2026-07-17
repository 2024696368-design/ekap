<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Login');
?>

<section class="auth-stage" id="ekap-vanta">
    <div class="container-xl">
        <div class="auth-grid">
            <div class="auth-intro">
                <?= $this->Html->image('ekap-logo-nav.png', [
                    'alt' => 'e-KAP',
                    'class' => 'auth-intro-logo',
                ]) ?>

                <h1><?= __('Student activity approval, simplified.') ?></h1>

                <p>
                    <?= __('Manage programme applications, supporting documents, HEP reviews, approvals and official letters through one secure platform.') ?>
                </p>

                <div class="auth-feature-list">
                    <div class="auth-feature">
                        <i class="bi bi-file-earmark-check"></i>
                        <strong><?= __('Digital Applications') ?></strong>
                        <span><?= __('Create, submit and monitor activity applications online.') ?></span>
                    </div>

                    <div class="auth-feature">
                        <i class="bi bi-shield-check"></i>
                        <strong><?= __('Structured Review') ?></strong>
                        <span><?= __('HEP reviews, comments and decisions remain clearly recorded.') ?></span>
                    </div>

                    <div class="auth-feature">
                        <i class="bi bi-filetype-pdf"></i>
                        <strong><?= __('Approval Letters') ?></strong>
                        <span><?= __('Generate formal PDF approval letters after a successful review.') ?></span>
                    </div>
                </div>
            </div>

            <div class="auth-card">
                <div class="auth-card-header">
                    <h2><?= __('Welcome back') ?></h2>
                    <p><?= __('Sign in to continue to your e-KAP dashboard.') ?></p>
                </div>

                <?= $this->Form->create(null, ['class' => 'auth-form']) ?>

                <?= $this->Form->control('email', [
                    'type' => 'email',
                    'label' => __('Email Address'),
                    'required' => true,
                    'autocomplete' => 'email',
                    'id' => 'email',
                    'placeholder' => 'name@uitm.edu.my',
                ]) ?>

                <?= $this->Form->control('password', [
                    'type' => 'password',
                    'label' => __('Password'),
                    'required' => true,
                    'autocomplete' => 'current-password',
                    'id' => 'password',
                    'placeholder' => __('Enter your password'),
                ]) ?>

                <div class="auth-actions">
                    <?= $this->Form->button(
                        '<i class="bi bi-box-arrow-in-right"></i>' . __('Login'),
                        ['escapeTitle' => false]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="bi bi-person-plus"></i>' . __('Register New User'),
                        '/register',
                        [
                            'class' => 'button button-outline',
                            'escape' => false,
                        ]
                    ) ?>
                </div>

                <?= $this->Form->end() ?>

                <div class="demo-credentials">
                    <h3><?= __('Demo Login') ?></h3>

                    <div class="demo-grid">
                        <button
                            type="button"
                            class="demo-card"
                            data-demo-email="admin@ekap.test"
                            data-demo-password="Password123!"
                        >
                            <strong><i class="bi bi-person-badge me-1"></i><?= __('Admin Demo') ?></strong>
                            <span>admin@ekap.test</span>
                            <span>Password123!</span>
                        </button>

                        <button
                            type="button"
                            class="demo-card"
                            data-demo-email="student@ekap.test"
                            data-demo-password="Password123!"
                        >
                            <strong><i class="bi bi-mortarboard me-1"></i><?= __('Student Demo') ?></strong>
                            <span>student@ekap.test</span>
                            <span>Password123!</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
