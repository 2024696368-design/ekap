<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Application> $applications
 * @var array $auth
 * @var string $search
 * @var string $status
 */

$role = $auth['role'] ?? 'student';
$isAdmin = $role === 'admin';
?>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-header h3 {
        margin-bottom: 4px;
    }

    .page-header p {
        margin: 0;
        color: #6b7280;
    }

    .page-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 22px;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.07);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: minmax(240px, 2fr) minmax(180px, 1fr) auto auto;
        gap: 12px;
        align-items: end;
    }

    .table-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.07);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .applications-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: collapse;
    }

    .applications-table th {
        background: #f8fafc;
        color: #374151;
        font-size: 13px;
        text-align: left;
        white-space: nowrap;
        padding: 13px 12px;
        border-bottom: 2px solid #e5e7eb;
    }

    .applications-table td {
        padding: 13px 12px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .applications-table tr:hover td {
        background: #fafafa;
    }

    .programme-title {
        min-width: 220px;
        font-weight: 600;
    }

    .reference-number {
        white-space: nowrap;
        font-size: 13px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-draft {
        background: #e5e7eb;
        color: #374151;
    }

    .status-submitted {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-under_review {
        background: #cffafe;
        color: #0e7490;
    }

    .status-changes_requested {
        background: #fef3c7;
        color: #92400e;
    }

    .status-approved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .table-actions {
        min-width: 150px;
        white-space: nowrap;
    }

    .table-actions a {
        margin-right: 8px;
    }

    .empty-state {
        text-align: center;
        color: #6b7280;
        padding: 40px !important;
    }

    .paginator {
        margin-top: 22px;
    }

    @media (max-width: 800px) {
        .page-header {
            display: block;
        }

        .page-actions {
            margin-top: 15px;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="applications index content">

    <div class="page-header">
        <div>
            <h3>
                <?= $isAdmin
                    ? __('Programme Applications')
                    : __('My Applications') ?>
            </h3>

            <p>
                <?= $isAdmin
                    ? __('Review and manage applications submitted by student societies.')
                    : __('Create, edit, submit, and monitor your programme applications.') ?>
            </p>
        </div>

        <div class="page-actions">
            <?= $this->Html->link(
                __('Dashboard'),
                '/dashboard',
                [
                    'class' => 'button button-outline',
                ]
            ) ?>

            <?php if (!$isAdmin): ?>
                <?= $this->Html->link(
                    __('+ New Application'),
                    [
                        'action' => 'add',
                    ],
                    [
                        'class' => 'button',
                    ]
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="filter-card">
        <?= $this->Form->create(null, [
            'type' => 'get',
        ]) ?>

        <div class="filter-grid">
            <?= $this->Form->control('search', [
                'label' => __('Search'),
                'value' => $search,
                'placeholder' =>
                    'Programme title, reference number, or club',
            ]) ?>

            <?= $this->Form->control('status', [
                'label' => __('Status'),
                'value' => $status,
                'empty' => __('All Statuses'),
                'options' => [
                    'draft' => 'Draft',
                    'submitted' => 'Submitted',
                    'under_review' => 'Under Review',
                    'changes_requested' => 'Changes Requested',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ],
            ]) ?>

            <?= $this->Form->button(
                __('Search'),
                [
                    'class' => 'button',
                ]
            ) ?>

            <?= $this->Html->link(
                __('Reset'),
                [
                    'action' => 'index',
                ],
                [
                    'class' => 'button button-outline',
                ]
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>
                            <?= $this->Paginator->sort(
                                'reference_no',
                                'Reference'
                            ) ?>
                        </th>

                        <th>
                            <?= $this->Paginator->sort(
                                'program_title',
                                'Programme'
                            ) ?>
                        </th>

                        <?php if ($isAdmin): ?>
                            <th><?= __('Student') ?></th>
                        <?php endif; ?>

                        <th><?= __('Club') ?></th>

                        <th>
                            <?= $this->Paginator->sort(
                                'program_category',
                                'Category'
                            ) ?>
                        </th>

                        <th>
                            <?= $this->Paginator->sort(
                                'start_datetime',
                                'Programme Date'
                            ) ?>
                        </th>

                        <th><?= __('Venue') ?></th>

                        <th>
                            <?= $this->Paginator->sort(
                                'total_participants',
                                'Participants'
                            ) ?>
                        </th>

                        <th>
                            <?= $this->Paginator->sort(
                                'estimated_budget',
                                'Budget'
                            ) ?>
                        </th>

                        <th>
                            <?= $this->Paginator->sort(
                                'status',
                                'Status'
                            ) ?>
                        </th>

                        <th class="actions">
                            <?= __('Actions') ?>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($applications)): ?>
                        <tr>
                            <td
                                colspan="<?= $isAdmin ? 11 : 10 ?>"
                                class="empty-state"
                            >
                                <?= __('No applications were found.') ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($applications as $application): ?>
                        <?php
                        $applicationStatus =
                            $application->status ?? 'draft';

                        $statusLabel = ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $applicationStatus
                            )
                        );

                        $canEdit =
                            !$isAdmin &&
                            in_array(
                                $applicationStatus,
                                [
                                    'draft',
                                    'changes_requested',
                                ],
                                true
                            );

                        $canDelete =
                            $isAdmin ||
                            (
                                !$isAdmin &&
                                $applicationStatus === 'draft'
                            );
                        ?>

                        <tr>
                            <td class="reference-number">
                                <?= h(
                                    $application->reference_no
                                    ?: 'Draft'
                                ) ?>
                            </td>

                            <td class="programme-title">
                                <?= h(
                                    $application->program_title
                                ) ?>
                            </td>

                            <?php if ($isAdmin): ?>
                                <td>
                                    <?php if (
                                        $application->hasValue('user')
                                    ): ?>
                                        <?= $this->Html->link(
                                            h(
                                                $application
                                                    ->user
                                                    ->full_name
                                            ),
                                            [
                                                'controller' => 'Users',
                                                'action' => 'view',
                                                $application->user->id,
                                            ]
                                        ) ?>
                                    <?php else: ?>
                                        <?= __('-') ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>

                            <td>
                                <?php if (
                                    $application->hasValue('club')
                                ): ?>
                                    <?= $this->Html->link(
                                        h(
                                            $application
                                                ->club
                                                ->club_name
                                        ),
                                        [
                                            'controller' => 'Clubs',
                                            'action' => 'view',
                                            $application->club->id,
                                        ]
                                    ) ?>
                                <?php else: ?>
                                    <?= __('-') ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= h(
                                    $application->program_category
                                    ?: '-'
                                ) ?>
                            </td>

                            <td>
                                <?php if (
                                    $application->start_datetime
                                ): ?>
                                    <?= h(
                                        $application
                                            ->start_datetime
                                            ->format(
                                                'd M Y, h:i A'
                                            )
                                    ) ?>
                                <?php else: ?>
                                    <?= __('-') ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= h(
                                    $application->venue
                                    ?: '-'
                                ) ?>
                            </td>

                            <td>
                                <?= $application
                                    ->total_participants === null
                                    ? '0'
                                    : $this->Number->format(
                                        $application
                                            ->total_participants
                                    ) ?>
                            </td>

                            <td>
                                RM
                                <?= $application
                                    ->estimated_budget === null
                                    ? '0.00'
                                    : number_format(
                                        (float)$application
                                            ->estimated_budget,
                                        2
                                    ) ?>
                            </td>

                            <td>
                                <span
                                    class="
                                        status-badge
                                        status-<?= h(
                                            $applicationStatus
                                        ) ?>
                                    "
                                >
                                    <?= h($statusLabel) ?>
                                </span>
                            </td>

                            <td class="table-actions">
                                <?= $this->Html->link(
                                    __('View'),
                                    [
                                        'action' => 'view',
                                        $application->id,
                                    ]
                                ) ?>

                                <?php if ($canEdit): ?>
                                    <?= $this->Html->link(
                                        __('Edit'),
                                        [
                                            'action' => 'edit',
                                            $application->id,
                                        ]
                                    ) ?>
                                <?php endif; ?>

                                <?php if ($canDelete): ?>
                                    <?= $this->Form->postLink(
                                        __('Delete'),
                                        [
                                            'action' => 'delete',
                                            $application->id,
                                        ],
                                        [
                                            'method' => 'delete',
                                            'confirm' => __(
                                                'Are you sure you want to delete this application?'
                                            ),
                                        ]
                                    ) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first(
                    '<< ' . __('first')
                ) ?>

                <?= $this->Paginator->prev(
                    '< ' . __('previous')
                ) ?>

                <?= $this->Paginator->numbers() ?>

                <?= $this->Paginator->next(
                    __('next') . ' >'
                ) ?>

                <?= $this->Paginator->last(
                    __('last') . ' >>'
                ) ?>
            </ul>

            <p>
                <?= $this->Paginator->counter(
                    __(
                        'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'
                    )
                ) ?>
            </p>
        </div>
    </div>
</div>