<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $auth
 * @var array<string, string> $roleOptions
 * @var array<string, string> $facultyOptions
 */

$isAdmin = ($auth['role'] ?? '') === 'admin';
$isOwnProfile =
    (int)($auth['id'] ?? 0) === (int)$user->id;
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
                __('View Profile'),
                ['action' => 'view', $user->id],
                ['class' => 'side-nav-item']
            ) ?>

            <?php if ($isAdmin): ?>
                <?= $this->Html->link(
                    __('List Users'),
                    ['action' => 'index'],
                    ['class' => 'side-nav-item']
                ) ?>

                <?php if (!$isOwnProfile): ?>
                    <?= $this->Form->postLink(
                        __('Delete User'),
                        ['action' => 'delete', $user->id],
                        [
                            'class' => 'side-nav-item',
                            'method' => 'delete',
                            'confirm' => __(
                                'Are you sure you want to delete this user account?'
                            ),
                        ]
                    ) ?>
                <?php endif; ?>
            <?php else: ?>
                <?= $this->Html->link(
                    __('Dashboard'),
                    '/dashboard',
                    ['class' => 'side-nav-item']
                ) ?>
            <?php endif; ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>

            <fieldset>
                <legend>
                    <?= $isAdmin
                        ? __('Edit User')
                        : __('Edit My Profile') ?>
                </legend>

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
                        'label' => __('New Password'),
                        'required' => false,
                        'value' => '',
                        'minlength' => 8,
                        'autocomplete' => 'new-password',
                        'help' => __(
                            'Leave blank to keep the current password.'
                        ),
                    ]) ?>

                    <?php if ($isAdmin): ?>
                        <?= $this->Form->control('role', [
                            'label' => __('Role'),
                            'options' => $roleOptions,
                            'required' => true,
                            'id' => 'role',
                        ]) ?>
                    <?php else: ?>
                        <div>
                            <label><?= __('Role') ?></label>
                            <p><strong><?= h(ucfirst($user->role)) ?></strong></p>
                        </div>
                    <?php endif; ?>

                    <?= $this->Form->control('faculty', [
                        'label' => __('Faculty'),
                        'options' => $facultyOptions,
                        'empty' => __('Select faculty'),
                        'required' => true,
                    ]) ?>

                    <div
                        id="student-id-field"
                        class="full-width"
                        <?= $user->role === 'admin' ? 'hidden' : '' ?>
                    >
                        <?= $this->Form->control('student_no', [
                            'label' => __('Student ID'),
                            'id' => 'student-no',
                        ]) ?>
                    </div>

                    <?php if ($isAdmin): ?>
                        <div
                            id="staff-id-field"
                            class="full-width"
                            <?= $user->role !== 'admin' ? 'hidden' : '' ?>
                        >
                            <?= $this->Form->control('staff_no', [
                                'label' => __('Staff ID'),
                                'id' => 'staff-no',
                            ]) ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->Form->control('phone', [
                        'label' => __('Phone Number'),
                    ]) ?>

                    <?php if ($isAdmin): ?>
                        <?= $this->Form->control('account_status', [
                            'label' => __('Account Status'),
                            'options' => [
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ],
                            'required' => true,
                        ]) ?>
                    <?php endif; ?>
                </div>
            </fieldset>

            <?= $this->Form->button(__('Save Changes')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php if ($isAdmin): ?>
<script>
(function () {
    const role = document.getElementById('role');
    const studentField = document.getElementById('student-id-field');
    const staffField = document.getElementById('staff-id-field');
    const studentInput = document.getElementById('student-no');
    const staffInput = document.getElementById('staff-no');

    function updateRoleFields() {
        const isAdminRole = role && role.value === 'admin';

        studentField.hidden = isAdminRole;
        staffField.hidden = !isAdminRole;
        studentInput.required = !isAdminRole;
        studentInput.disabled = isAdminRole;
        staffInput.required = isAdminRole;
        staffInput.disabled = !isAdminRole;
    }

    if (role) {
        role.addEventListener('change', updateRoleFields);
        updateRoleFields();
    }
})();
</script>
<?php endif; ?>
