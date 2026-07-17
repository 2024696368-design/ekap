<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */

$session = $this->request->getSession();
$auth = $session->read('Auth') ?? [];

$isStudent = ($auth['role'] ?? '') === 'student';
$isAdmin = ($auth['role'] ?? '') === 'admin';

$ownsApplication =
    $isStudent &&
    (int)$application->user_id === (int)($auth['id'] ?? 0);

$editableStatuses = [
    'draft',
    'changes_requested',
];

$canEdit =
    $ownsApplication &&
    in_array(
        $application->status,
        $editableStatuses,
        true
    );

$canSubmit =
    $ownsApplication &&
    in_array(
        $application->status,
        $editableStatuses,
        true
    );

$canDelete =
    $isAdmin ||
    (
        $ownsApplication &&
        $application->status === 'draft'
    );

$status = $application->status ?? 'draft';

$statusLabel = ucwords(
    str_replace('_', ' ', $status)
);

$formatDateTime = static function ($value): string {
    if ($value === null) {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format('d M Y, h:i A');
    }

    return (string)$value;
};
?>

<style>
    .application-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 24px;
    }

    .application-header h1 {
        margin-bottom: 6px;
    }

    .application-header p {
        margin: 0;
        color: #6b7280;
    }

    .header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .application-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: #ffffff;
        padding: 18px;
        border-radius: 10px;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.07);
    }

    .summary-card span {
        display: block;
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .summary-card strong {
        font-size: 16px;
        color: #1f2937;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
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

    .application-layout {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(260px, 1fr);
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
        padding: 11px 10px;
        text-align: left;
        vertical-align: top;
        border-bottom: 1px solid #e5e7eb;
    }

    .details-table th {
        width: 35%;
        color: #4b5563;
        background: #f9fafb;
    }

    .text-section {
        margin-bottom: 20px;
    }

    .text-section:last-child {
        margin-bottom: 0;
    }

    .text-section h3 {
        font-size: 15px;
        margin-bottom: 8px;
        color: #374151;
    }

    .text-box {
        padding: 14px;
        background: #f9fafb;
        border-radius: 8px;
        white-space: normal;
    }

    .side-action-list {
        display: grid;
        gap: 10px;
    }

    .side-action-list .button,
    .side-action-list form,
    .side-action-list form button {
        width: 100%;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .related-table {
        width: 100%;
        min-width: 700px;
        border-collapse: collapse;
    }

    .related-table th,
    .related-table td {
        padding: 11px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
    }

    .related-table th {
        background: #f9fafb;
        white-space: nowrap;
    }

    .empty-message {
        color: #6b7280;
        margin: 0;
    }

    .admin-comment {
        padding: 15px;
        background: #fff7ed;
        border-left: 4px solid #f59e0b;
        border-radius: 6px;
    }

    @media (max-width: 900px) {
        .application-summary {
            grid-template-columns: 1fr;
        }

        .application-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="applications view content">

    <div class="application-header">
        <div>
            <p>
                <?= h(
                    $application->reference_no
                    ?: 'Draft Application'
                ) ?>
            </p>

            <h1>
                <?= h($application->program_title) ?>
            </h1>

            <span class="status-badge status-<?= h($status) ?>">
                <?= h($statusLabel) ?>
            </span>
        </div>

        <div class="header-actions">
            <?= $this->Html->link(
                __('Dashboard'),
                '/dashboard',
                [
                    'class' => 'button button-outline',
                ]
            ) ?>

            <?= $this->Html->link(
                __('Back to Applications'),
                [
                    'action' => 'index',
                ],
                [
                    'class' => 'button button-outline',
                ]
            ) ?>

            <?php if ($canEdit): ?>
                <?= $this->Html->link(
                    __('Edit Application'),
                    [
                        'action' => 'edit',
                        $application->id,
                    ],
                    [
                        'class' => 'button button-outline',
                    ]
                ) ?>
            <?php endif; ?>

            <?php if ($canSubmit): ?>
                <?= $this->Form->postLink(
                    __('Submit Application'),
                    [
                        'action' => 'submit',
                        $application->id,
                    ],
                    [
                        'class' => 'button',
                        'confirm' => __(
                            'Submit this application to HEP? You will not be able to edit it after submission unless HEP requests changes.'
                        ),
                    ]
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="application-summary">
        <div class="summary-card">
            <span><?= __('Reference Number') ?></span>

            <strong>
                <?= h(
                    $application->reference_no
                    ?: 'Not generated yet'
                ) ?>
            </strong>
        </div>

        <div class="summary-card">
            <span><?= __('Current Status') ?></span>

            <strong>
                <?= h($statusLabel) ?>
            </strong>
        </div>

        <div class="summary-card">
            <span><?= __('Submitted At') ?></span>

            <strong>
                <?= h(
                    $formatDateTime(
                        $application->submitted_at
                    )
                ) ?>
            </strong>
        </div>
    </div>

    <div class="application-layout">

        <main>
            <div class="content-card">
                <h2><?= __('Programme Information') ?></h2>

                <table class="details-table">
                    <?php if ($isAdmin): ?>
                        <tr>
                            <th><?= __('Student Representative') ?></th>

                            <td>
                                <?php if ($application->hasValue('user')): ?>
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
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <th><?= __('Society / Club') ?></th>

                        <td>
                            <?php if ($application->hasValue('club')): ?>
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
                    </tr>

                    <tr>
                        <th><?= __('Organiser Type') ?></th>
                        <td><?= h($application->organiser_type ?: '-') ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Programme Title') ?></th>
                        <td><?= h($application->program_title ?: '-') ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Programme Level') ?></th>
                        <td><?= h($application->program_level ?: '-') ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Programme Category') ?></th>
                        <td><?= h($application->program_category ?: '-') ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Venue') ?></th>
                        <td><?= h($application->venue ?: '-') ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Target Group') ?></th>
                        <td><?= h($application->target_group ?: '-') ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Start Date and Time') ?></th>

                        <td>
                            <?= h(
                                $formatDateTime(
                                    $application
                                        ->start_datetime
                                )
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('End Date and Time') ?></th>

                        <td>
                            <?= h(
                                $formatDateTime(
                                    $application
                                        ->end_datetime
                                )
                            ) ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="content-card">
                <h2><?= __('Programme Description') ?></h2>

                <div class="text-section">
                    <h3><?= __('Description') ?></h3>

                    <div class="text-box">
                        <?= $this->Text->autoParagraph(
                            h(
                                $application
                                    ->program_description
                                ?: 'Not provided.'
                            )
                        ) ?>
                    </div>
                </div>

                <div class="text-section">
                    <h3><?= __('Objectives') ?></h3>

                    <div class="text-box">
                        <?= $this->Text->autoParagraph(
                            h(
                                $application->objectives
                                ?: 'Not provided.'
                            )
                        ) ?>
                    </div>
                </div>

                <div class="text-section">
                    <h3><?= __('Expected Outcomes') ?></h3>

                    <div class="text-box">
                        <?= $this->Text->autoParagraph(
                            h(
                                $application
                                    ->expected_outcomes
                                ?: 'Not provided.'
                            )
                        ) ?>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <h2><?= __('Supporting Documents') ?></h2>

                <?php if (!empty($application->documents)): ?>
                    <div class="table-responsive">
                        <table class="related-table">
                            <thead>
                                <tr>
                                    <th><?= __('Document Type') ?></th>
                                    <th><?= __('File Name') ?></th>
                                    <th><?= __('File Type') ?></th>
                                    <th><?= __('File Size') ?></th>
                                    <th><?= __('Uploaded') ?></th>
                                    <th><?= __('Action') ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (
                                    $application->documents
                                    as $document
                                ): ?>
                                    <tr>
                                        <td>
                                            <?= h(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $document
                                                            ->document_type
                                                    )
                                                )
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $document->file_name
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $document->file_type
                                                ?: '-'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?php if (
                                                $document->file_size
                                            ): ?>
                                                <?= h(
                                                    number_format(
                                                        (float)$document
                                                            ->file_size
                                                        / 1024,
                                                        2
                                                    )
                                                ) ?>
                                                KB
                                            <?php else: ?>
                                                <?= __('-') ?>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $formatDateTime(
                                                    $document->created
                                                )
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $this->Html->link(
                                                __('View'),
                                                [
                                                    'controller' =>
                                                        'Documents',
                                                    'action' => 'view',
                                                    $document->id,
                                                ]
                                            ) ?>

                                            <?php if ($canEdit): ?>
                                                <?= $this->Html->link(
                                                    __('Edit'),
                                                    [
                                                        'controller' =>
                                                            'Documents',
                                                        'action' =>
                                                            'edit',
                                                        $document->id,
                                                    ]
                                                ) ?>

                                                <?= $this->Form->postLink(
                                                    __('Delete'),
                                                    [
                                                        'controller' =>
                                                            'Documents',
                                                        'action' =>
                                                            'delete',
                                                        $document->id,
                                                    ],
                                                    [
                                                        'method' =>
                                                            'delete',
                                                        'confirm' => __(
                                                            'Delete this document?'
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
                        <?= __('No supporting documents have been uploaded.') ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="content-card">
                <h2><?= __('HEP Review History') ?></h2>

                <?php if (!empty($application->reviews)): ?>
                    <div class="table-responsive">
                        <table class="related-table">
                            <thead>
                                <tr>
                                    <th><?= __('Decision') ?></th>
                                    <th><?= __('Comments') ?></th>

                                    <?php if ($isAdmin): ?>
                                        <th><?= __('Internal Notes') ?></th>
                                    <?php endif; ?>

                                    <th><?= __('Reviewed At') ?></th>

                                    <?php if ($isAdmin): ?>
                                        <th><?= __('Actions') ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (
                                    $application->reviews
                                    as $review
                                ): ?>
                                    <tr>
                                        <td>
                                            <?= h(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $review->decision
                                                    )
                                                )
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= h(
                                                $review->comments
                                                ?: '-'
                                            ) ?>
                                        </td>

                                        <?php if ($isAdmin): ?>
                                            <td>
                                                <?= h(
                                                    $review
                                                        ->internal_notes
                                                    ?: '-'
                                                ) ?>
                                            </td>
                                        <?php endif; ?>

                                        <td>
                                            <?= h(
                                                $formatDateTime(
                                                    $review->created
                                                )
                                            ) ?>
                                        </td>

                                        <?php if ($isAdmin): ?>
                                            <td>
                                                <?= $this->Html->link(
                                                    __('View'),
                                                    [
                                                        'controller' =>
                                                            'Reviews',
                                                        'action' =>
                                                            'view',
                                                        $review->id,
                                                    ]
                                                ) ?>

                                                <?= $this->Html->link(
                                                    __('Edit'),
                                                    [
                                                        'controller' =>
                                                            'Reviews',
                                                        'action' =>
                                                            'edit',
                                                        $review->id,
                                                    ]
                                                ) ?>

                                                <?= $this->Form->postLink(
                                                    __('Delete'),
                                                    [
                                                        'controller' =>
                                                            'Reviews',
                                                        'action' =>
                                                            'delete',
                                                        $review->id,
                                                    ],
                                                    [
                                                        'method' =>
                                                            'delete',
                                                        'confirm' => __(
                                                            'Delete this review record?'
                                                        ),
                                                    ]
                                                ) ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="empty-message">
                        <?= __('HEP has not reviewed this application yet.') ?>
                    </p>
                <?php endif; ?>
            </div>
        </main>

        <aside>
            <div class="content-card">
                <h2><?= __('Participation') ?></h2>

                <table class="details-table">
                    <tr>
                        <th><?= __('Male') ?></th>
                        <td>
                            <?= $this->Number->format(
                                $application
                                    ->male_participants
                                ?? 0
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Female') ?></th>
                        <td>
                            <?= $this->Number->format(
                                $application
                                    ->female_participants
                                ?? 0
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Total') ?></th>
                        <td>
                            <?= $this->Number->format(
                                $application
                                    ->total_participants
                                ?? 0
                            ) ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="content-card">
                <h2><?= __('Financial Information') ?></h2>

                <table class="details-table">
                    <tr>
                        <th><?= __('Estimated Budget') ?></th>

                        <td>
                            RM
                            <?= number_format(
                                (float)(
                                    $application
                                        ->estimated_budget
                                    ?? 0
                                ),
                                2
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Requested Allocation') ?></th>

                        <td>
                            RM
                            <?= number_format(
                                (float)(
                                    $application
                                        ->requested_allocation
                                    ?? 0
                                ),
                                2
                            ) ?>
                        </td>
                    </tr>

                    <?php if (
                        $application->approved_amount !== null
                    ): ?>
                        <tr>
                            <th><?= __('Approved Allocation') ?></th>

                            <td>
                                <strong>
                                    RM
                                    <?= number_format(
                                        (float)$application
                                            ->approved_amount,
                                        2
                                    ) ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <th><?= __('Funding Source') ?></th>

                        <td>
                            <?= h(
                                $application->funding_source
                                ?: '-'
                            ) ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="content-card">
                <h2><?= __('Person in Charge') ?></h2>

                <table class="details-table">
                    <tr>
                        <th><?= __('Name') ?></th>

                        <td>
                            <?= h(
                                $application
                                    ->person_in_charge
                                ?: '-'
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Phone') ?></th>

                        <td>
                            <?= h(
                                $application->pic_phone
                                ?: '-'
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Email') ?></th>

                        <td>
                            <?= h(
                                $application->pic_email
                                ?: '-'
                            ) ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="content-card">
                <h2><?= __('Risk Assessment') ?></h2>

                <table class="details-table">
                    <tr>
                        <th><?= __('Has Risk') ?></th>

                        <td>
                            <?= $application->has_risk
                                ? __('Yes')
                                : __('No') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?= __('Risk Level') ?></th>

                        <td>
                            <?= h(
                                $application->risk_level
                                    ? ucfirst(
                                        $application->risk_level
                                    )
                                    : '-'
                            ) ?>
                        </td>
                    </tr>
                </table>

                <?php if ($application->has_risk): ?>
                    <div class="text-section">
                        <h3><?= __('Risk Description') ?></h3>

                        <div class="text-box">
                            <?= $this->Text->autoParagraph(
                                h(
                                    $application
                                        ->risk_description
                                    ?: 'Not provided.'
                                )
                            ) ?>
                        </div>
                    </div>

                    <div class="text-section">
                        <h3><?= __('Safety Action') ?></h3>

                        <div class="text-box">
                            <?= $this->Text->autoParagraph(
                                h(
                                    $application
                                        ->safety_action
                                    ?: 'Not provided.'
                                )
                            ) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($application->admin_comment)): ?>
                <div class="content-card">
                    <h2><?= __('HEP Comment') ?></h2>

                    <div class="admin-comment">
                        <?= $this->Text->autoParagraph(
                            h(
                                $application
                                    ->admin_comment
                            )
                        ) ?>
                    </div>
                </div>
            <?php endif; ?>

            
                <?php if (
                    $isAdmin &&
                    in_array(
                        $status,
                        ['submitted', 'under_review'],
                        true
                    )
                ): ?>
                    <div class="content-card">
                        <h2><?= __('HEP Review') ?></h2>

                        <p style="color: #6b7280; margin-bottom: 18px;">
                            <?= __(
                                'Review the programme details and supporting documents before recording a decision.'
                            ) ?>
                        </p>

                        <?= $this->Form->create(
                            null,
                            [
                                'url' => [
                                    'action' => 'review',
                                    $application->id,
                                ],
                            ]
                        ) ?>

                        <?= $this->Form->control(
                            'decision',
                            [
                                'label' => __('Decision'),
                                'empty' => __('Select a decision'),
                                'required' => true,
                                'options' => [
                                    'under_review' => 'Mark as Under Review',
                                    'changes_requested' => 'Request Changes',
                                    'approved' => 'Approve Application',
                                    'rejected' => 'Reject Application',
                                ],
                            ]
                        ) ?>


                        <?= $this->Form->control(
                            'approved_amount',
                            [
                                'type' => 'number',
                                'label' =>
                                    __('Approved Allocation (RM)'),

                                'min' => 0,
                                'step' => '0.01',

                                'value' =>
                                    $application->approved_amount
                                    ?? $application->requested_allocation,

                                'help' =>
                                    'Required only when approving the application.',
                            ]
                        ) ?>


                        <?= $this->Form->control(
                            'comments',
                            [
                                'type' => 'textarea',
                                'rows' => 5,
                                'label' => __('Comments to Student'),
                                'placeholder' =>
                                    'Explain corrections, approval conditions, or the rejection reason.',
                            ]
                        ) ?>

                        <p style="
                            margin-top: -10px;
                            margin-bottom: 18px;
                            color: #6b7280;
                            font-size: 12px;
                        ">
                            <?= __(
                                'Comments are required when requesting changes or rejecting an application.'
                            ) ?>
                        </p>

                        <?= $this->Form->control(
                            'internal_notes',
                            [
                                'type' => 'textarea',
                                'rows' => 4,
                                'label' => __('Internal HEP Notes'),
                                'placeholder' =>
                                    'These notes are visible only to HEP administrators.',
                            ]
                        ) ?>

                        <?= $this->Form->button(
                            __('Save HEP Decision'),
                            [
                                'class' => 'button',
                                'style' => 'width: 100%;',
                                'confirm' =>
                                    'Are you sure you want to save this HEP decision?',
                            ]
                        ) ?>

                        <?= $this->Form->end() ?>
                    </div>
                <?php endif; ?>

                <?php if (
                    $isAdmin &&
                    in_array(
                        $status,
                        ['approved', 'rejected', 'changes_requested'],
                        true
                    )
                ): ?>
                    <div class="content-card">
                        <h2><?= __('HEP Decision') ?></h2>

                        <p>
                            <span class="status-badge status-<?= h($status) ?>">
                                <?= h($statusLabel) ?>
                            </span>
                        </p>

                        <?php if (!empty($application->admin_comment)): ?>
                            <div class="admin-comment">
                                <?= $this->Text->autoParagraph(
                                    h($application->admin_comment)
                                ) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($status === 'changes_requested'): ?>
                            <p style="color: #6b7280; margin-top: 15px;">
                                <?= __(
                                    'The student must edit and resubmit the application before HEP can continue reviewing it.'
                                ) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>


            <div class="content-card">
                <h2><?= __('Actions') ?></h2>

                <div class="side-action-list">
                    <?= $this->Html->link(
                        __('Back to Applications'),
                        [
                            'action' => 'index',
                        ],
                        [
                            'class' =>
                                'button button-outline',
                        ]
                    ) ?>

                    <?php if ($isStudent): ?>
                        <?= $this->Html->link(
                            __('New Application'),
                            [
                                'action' => 'add',
                            ],
                            [
                                'class' =>
                                    'button button-outline',
                            ]
                        ) ?>
                    <?php endif; ?>

                    <?php if ($canEdit): ?>
                        <?= $this->Html->link(
                            __('Edit Application'),
                            [
                                'action' => 'edit',
                                $application->id,
                            ],
                            [
                                'class' =>
                                    'button button-outline',
                            ]
                        ) ?>
                    <?php endif; ?>

                    <?php if ($canSubmit): ?>
                        <?= $this->Form->postLink(
                            __('Submit to HEP'),
                            [
                                'action' => 'submit',
                                $application->id,
                            ],
                            [
                                'class' => 'button',
                                'confirm' => __(
                                    'Are you sure you want to submit this application to HEP?'
                                ),
                            ]
                        ) ?>
                    <?php endif; ?>

                    <?php if ($status === 'approved'): ?>
                        <?= $this->Html->link(
                            __('View Approval Letter PDF'),
                            [
                                'action' => 'approvalLetter',
                                $application->id,
                            ],
                            [
                                'class' => 'button',
                                'target' => '_blank',
                            ]
                        ) ?>
                    <?php endif; ?>

                    <?php if ($canDelete): ?>
                        <?= $this->Form->postLink(
                            __('Delete Application'),
                            [
                                'action' => 'delete',
                                $application->id,
                            ],
                            [
                                'class' =>
                                    'button button-outline',
                                'method' => 'delete',
                                'confirm' => __(
                                    'Are you sure you want to delete this application?'
                                ),
                            ]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</div>