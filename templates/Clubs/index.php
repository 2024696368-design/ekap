<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Club> $clubs
 */

$auth = $this->request
    ->getSession()
    ->read('Auth') ?? [];

$isAdmin = ($auth['role'] ?? '') === 'admin';
?>

<div class="clubs index content">

    <?php if ($isAdmin): ?>
        <?= $this->Html->link(
            __('New Club'),
            [
                'action' => 'add',
            ],
            [
                'class' => 'button float-right',
            ]
        ) ?>
    <?php endif; ?>

    <h3><?= __('Clubs') ?></h3>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>
                        <?= $this->Paginator->sort(
                            'id',
                            'ID'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'club_name',
                            'Club Name'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'registration_no',
                            'Registration No.'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'faculty',
                            'Faculty'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'advisor_name',
                            'Advisor'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'advisor_email',
                            'Advisor Email'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'status',
                            'Status'
                        ) ?>
                    </th>

                    <th>
                        <?= $this->Paginator->sort(
                            'created',
                            'Created'
                        ) ?>
                    </th>

                    <th class="actions">
                        <?= __('Actions') ?>
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($clubs as $club): ?>
                    <tr>
                        <td>
                            <?= $this->Number->format(
                                $club->id
                            ) ?>
                        </td>

                        <td>
                            <?= h($club->club_name) ?>
                        </td>

                        <td>
                            <?= h(
                                $club->registration_no
                                ?: '-'
                            ) ?>
                        </td>

                        <td>
                            <?= h(
                                $club->faculty
                                ?: '-'
                            ) ?>
                        </td>

                        <td>
                            <?= h(
                                $club->advisor_name
                                ?: '-'
                            ) ?>
                        </td>

                        <td>
                            <?= h(
                                $club->advisor_email
                                ?: '-'
                            ) ?>
                        </td>

                        <td>
                            <?= h(
                                ucfirst(
                                    $club->status
                                    ?: 'inactive'
                                )
                            ) ?>
                        </td>

                        <td>
                            <?= $club->created
                                ? h(
                                    $club->created->format(
                                        'd M Y'
                                    )
                                )
                                : '-' ?>
                        </td>

                        <td class="actions">
                            <?= $this->Html->link(
                                __('View'),
                                [
                                    'action' => 'view',
                                    $club->id,
                                ]
                            ) ?>

                            <?php if ($isAdmin): ?>
                                <?= $this->Html->link(
                                    __('Edit'),
                                    [
                                        'action' => 'edit',
                                        $club->id,
                                    ]
                                ) ?>

                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    [
                                        'action' => 'delete',
                                        $club->id,
                                    ],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __(
                                            'Are you sure you want to delete this club?'
                                        ),
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($clubs)): ?>
                    <tr>
                        <td colspan="9">
                            <?= __('No clubs were found.') ?>
                        </td>
                    </tr>
                <?php endif; ?>
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