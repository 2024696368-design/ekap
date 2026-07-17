<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users view content">
            <h3><?= h($user->full_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Full Name') ?></th>
                    <td><?= h($user->full_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Student No') ?></th>
                    <td><?= h($user->student_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Staff No') ?></th>
                    <td><?= h($user->staff_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Faculty') ?></th>
                    <td><?= h($user->faculty) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($user->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account Status') ?></th>
                    <td><?= h($user->account_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Applications') ?></h4>
                <?php if (!empty($user->applications)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Club Id') ?></th>
                            <th><?= __('Reference No') ?></th>
                            <th><?= __('Organiser Type') ?></th>
                            <th><?= __('Program Title') ?></th>
                            <th><?= __('Program Level') ?></th>
                            <th><?= __('Program Category') ?></th>
                            <th><?= __('Venue') ?></th>
                            <th><?= __('Target Group') ?></th>
                            <th><?= __('Start Datetime') ?></th>
                            <th><?= __('End Datetime') ?></th>
                            <th><?= __('Male Participants') ?></th>
                            <th><?= __('Female Participants') ?></th>
                            <th><?= __('Total Participants') ?></th>
                            <th><?= __('Program Description') ?></th>
                            <th><?= __('Objectives') ?></th>
                            <th><?= __('Expected Outcomes') ?></th>
                            <th><?= __('Estimated Budget') ?></th>
                            <th><?= __('Requested Allocation') ?></th>
                            <th><?= __('Funding Source') ?></th>
                            <th><?= __('Has Risk') ?></th>
                            <th><?= __('Risk Level') ?></th>
                            <th><?= __('Risk Description') ?></th>
                            <th><?= __('Safety Action') ?></th>
                            <th><?= __('Person In Charge') ?></th>
                            <th><?= __('Pic Phone') ?></th>
                            <th><?= __('Pic Email') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Admin Comment') ?></th>
                            <th><?= __('Submitted At') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->applications as $application) : ?>
                        <tr>
                            <td><?= h($application->id) ?></td>
                            <td><?= h($application->club_id) ?></td>
                            <td><?= h($application->reference_no) ?></td>
                            <td><?= h($application->organiser_type) ?></td>
                            <td><?= h($application->program_title) ?></td>
                            <td><?= h($application->program_level) ?></td>
                            <td><?= h($application->program_category) ?></td>
                            <td><?= h($application->venue) ?></td>
                            <td><?= h($application->target_group) ?></td>
                            <td><?= h($application->start_datetime) ?></td>
                            <td><?= h($application->end_datetime) ?></td>
                            <td><?= h($application->male_participants) ?></td>
                            <td><?= h($application->female_participants) ?></td>
                            <td><?= h($application->total_participants) ?></td>
                            <td><?= h($application->program_description) ?></td>
                            <td><?= h($application->objectives) ?></td>
                            <td><?= h($application->expected_outcomes) ?></td>
                            <td><?= h($application->estimated_budget) ?></td>
                            <td><?= h($application->requested_allocation) ?></td>
                            <td><?= h($application->funding_source) ?></td>
                            <td><?= h($application->has_risk) ?></td>
                            <td><?= h($application->risk_level) ?></td>
                            <td><?= h($application->risk_description) ?></td>
                            <td><?= h($application->safety_action) ?></td>
                            <td><?= h($application->person_in_charge) ?></td>
                            <td><?= h($application->pic_phone) ?></td>
                            <td><?= h($application->pic_email) ?></td>
                            <td><?= h($application->status) ?></td>
                            <td><?= h($application->admin_comment) ?></td>
                            <td><?= h($application->submitted_at) ?></td>
                            <td><?= h($application->created) ?></td>
                            <td><?= h($application->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $application->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $application->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Applications', 'action' => 'delete', $application->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $application->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>