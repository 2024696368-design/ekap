<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array<string, string> $roleOptions
 * @var array<string, string> $facultyOptions
 */
?>

<style>
    .user-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0 18px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    [hidden] {
        display: none !important;
    }

    @media (max-width: 650px) {
        .user-form-grid {
            grid-template-columns: 1fr;
        }

        .full-width {
            grid-column: auto;
        }
    }
</style>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?= $this->Html->link(
                __('List Users'),
                ['action' => 'index'],
                ['class' => 'side-nav-item']
            ) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>

            <fieldset>
                <legend><?= __('Add New User') ?></legend>

                <div class="user-form-grid">
                    <div class="full-width">
                        <?= $this->Form->control('full_name', [
                            'label' => __('Full Name'),
                            'required' => true,
                        ]) ?>
                    </div>

                    <?= $this->Form->control('email', [
                        'type' => 'email',
                        'label' => __('Email Address'),
                        'required' => true,
                    ]) ?>

                    <?= $this->Form->control('password', [
                        'type' => 'password',
                        'label' => __('Password'),
                        'required' => true,
                        'minlength' => 8,
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
                        ]) ?>
                    </div>

                    <div id="staff-id-field" class="full-width" hidden>
                        <?= $this->Form->control('staff_no', [
                            'label' => __('Staff ID'),
                            'id' => 'staff-no',
                        ]) ?>
                    </div>

                    <?= $this->Form->control('phone', [
                        'label' => __('Phone Number'),
                    ]) ?>

                    <?= $this->Form->control('account_status', [
                        'label' => __('Account Status'),
                        'options' => [
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                        ],
                        'default' => 'active',
                        'required' => true,
                    ]) ?>
                </div>
            </fieldset>

            <?= $this->Form->button(__('Create User')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
(function () {
    const role = document.getElementById('role');
    const studentField = document.getElementById('student-id-field');
    const staffField = document.getElementById('staff-id-field');
    const studentInput = document.getElementById('student-no');
    const staffInput = document.getElementById('staff-no');

    function updateRoleFields() {
        const isAdmin = role && role.value === 'admin';

        studentField.hidden = isAdmin;
        staffField.hidden = !isAdmin;
        studentInput.required = !isAdmin;
        studentInput.disabled = isAdmin;
        staffInput.required = isAdmin;
        staffInput.disabled = !isAdmin;
    }

    if (role) {
        role.addEventListener('change', updateRoleFields);
        updateRoleFields();
    }
})();
</script>
