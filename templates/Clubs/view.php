<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Club $club
 */

$auth = $this->request
    ->getSession()
    ->read('Auth') ?? [];

$isAdmin = ($auth['role'] ?? '') === 'admin';
?>

<style>
    .club-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 24px;
    }

    .club-header h1 {
        margin-bottom: 6px;
    }

    .club-header p {
        margin: 0;
        color: #6b7280;
    }

    .header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .club-layout {
        display: grid;
        grid-template-columns: minmax(240px, 1fr) minmax(0, 2fr);
        gap: 24px;
    }

    .content-card {
        background: #ffffff;
        padding: 22px;
        border-radius: 10px;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.07);
        margin-bottom: 24px;
    }

    .content-card h2 {
        font-size: 19px;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
    }

    .details-table th,
    .details-table td {
        padding: 12px 10px;
        text-align: left;
        vertical-align: top;
        border-bottom: 1px solid #e5e7eb;
    }

    .details-table th {
        width: 38%;
        color: #4b5563;
        background: #f9fafb;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .applications-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .applications-table th,
    .applications-table td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }

    .applications-table th {
        background: #f9fafb;
        white-space: nowrap;
    }

    .applications-table tr:hover td {
        background: #fafafa;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-active,
    .status-approved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive,
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
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

    .action-list {
        display: grid;
        gap: 10px;
    }

    .action-list .button,
    .action-list form,
    .action-list form button {
        width: 100%;
    }

    .empty-message {
        color: #6b7280;
        margin: 0;
    }

    @media (max-width: 850px) {
        .club-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="clubs view content">

    <div class="club-header">
        <div>
            <p><?= __('Club Information') ?></p>

            <h1><?= h($club->club_name) ?></h1>

            <?php
            $clubStatus = $club->status ?: 'inactive';
            ?>

            <span class="status-badge status-<?= h($clubStatus) ?>">
                <?= h(ucfirst($clubStatus)) ?>
            </span>
        </div>

        <div class="header-actions">
            <?= $this->Html->link(
                __('Back to Clubs'),
                [
                    'action' => 'index',
                ],
                [
                    'class' => 'button button-outline',
                ]
            ) ?>

            <?php if ($isAdmin): ?>
                <?= $this->Html->link(
                    __('Edit Club'),
                    [
                        'action' => 'edit',
                        $club->id,
                    ],
                    [
                        'class' => 'button',
                    ]
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="club-layout">

        <aside>
            <div class="content-card">
                <h2><?= __('Club Details') ?></h2>

                <table class="details-table">
                    <tr>
                        <th><?= __('Club Name') ?></th>

                        <td>
                            <?= h($club->club_name ?: '-') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Registration No.') ?></th>

                        <td>
                            <?= h($club->registration_no ?: '-') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Faculty') ?></th>

                        <td>
                            <?= h($club->faculty ?: '-') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Advisor Name') ?></th>

                        <td>
                            <?= h($club->advisor_name ?: '-') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Advisor Email') ?></th>

                        <td>
                            <?php if (!empty($club->advisor_email)): ?>
                                <a href="mailto:<?= h($club->advisor_email) ?>">
                                    <?= h($club->advisor_email) ?>
                                </a>
                            <?php else: ?>
                                <?= __('-') ?>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Status') ?></th>

                        <td>
                            <?= h(ucfirst($clubStatus)) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Created') ?></th>

                        <td>
                            <?= $club->created
                                ? h($club->created->format('d M Y, h:i A'))
                                : '-' ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Last Modified') ?></th>

                        <td>
                            <?= $club->modified
                                ? h($club->modified->format('d M Y, h:i A'))
                                : '-' ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="content-card">
                <h2><?= __('Actions') ?></h2>

                <div class="action-list">
                    <?= $this->Html->link(
                        __('List Clubs'),
                        [
                            'action' => 'index',
                        ],
                        [
                            'class' => 'button button-outline',
                        ]
                    ) ?>

                    <?php if ($isAdmin): ?>
                        <?= $this->Html->link(
                            __('Edit Club'),
                            [
                                'action' => 'edit',
                                $club->id,
                            ],
                            [
                                'class' => 'button button-outline',
                            ]
                        ) ?>

                        <?= $this->Html->link(
                            __('New Club'),
                            [
                                'action' => 'add',
                            ],
                            [
                                'class' => 'button button-outline',
                            ]
                        ) ?>

                        <?= $this->Form->postLink(
                            __('Delete Club'),
                            [
                                'action' => 'delete',
                                $club->id,
                            ],
                            [
                                'class' => 'button button-outline',
                                'method' => 'delete',
                                'confirm' => __(
                                    'Are you sure you want to delete this club?'
                                ),
                            ]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <main>
            <div class="content-card">
                <h2><?= __('Related Applications') ?></h2>

                <?php if (!empty($club->applications)): ?>
                    <div class="table-responsive">
                        <table class="applications-table">
                            <thead>
                                <tr>
                                    <th><?= __('Reference') ?></th>
                                    <th><?= __('Programme') ?></th>
                                    <th><?= __('Category') ?></th>
                                    <th><?= __('Programme Date') ?></th>
                                    <th><?= __('Venue') ?></th>
                                    <th><?= __('Participants') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Action') ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (
                                    $club->applications
                                    as $application
                                ): ?>
                                    <?php
                                    $applicationStatus =
                                        $application->status ?: 'draft';

                                    $statusLabel = ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $applicationStatus
                                        )
                                    );
                                    ?>

                                    <tr>
                                        <td>
                                            <?= h(
                                                $application->reference_no
                                                ?: 'Draft'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $application->program_title
                                                ?: '-'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $application->program_category
                                                ?: '-'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $application->start_datetime
                                                ? h(
                                                    $application
                                                        ->start_datetime
                                                        ->format('d M Y')
                                                )
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $application->venue
                                                ?: '-'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $this->Number->format(
                                                $application
                                                    ->total_participants
                                                ?? 0
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

                                        <td>
                                            <?= $this->Html->link(
                                                __('View'),
                                                [
                                                    'controller' =>
                                                        'Applications',

                                                    'action' => 'view',
                                                    $application->id,
                                                ]
                                            ) ?>

                                            <?php if ($isAdmin): ?>
                                                <?= $this->Form->postLink(
                                                    __('Delete'),
                                                    [
                                                        'controller' =>
                                                            'Applications',

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
                <?php else: ?>
                    <p class="empty-message">
                        <?= __('No applications are associated with this club.') ?>
                    </p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>