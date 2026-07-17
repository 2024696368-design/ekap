<?php
/**
 * @var \App\View\AppView $this
 * @var array $auth
 * @var array $counts
 * @var \Cake\Datasource\ResultSetInterface $recentApplications
 */

$this->assign('title', 'Dashboard');
$isAdmin = ($auth['role'] ?? '') === 'admin';
$isStudent = ($auth['role'] ?? '') === 'student';
$fullName = $auth['full_name'] ?? 'User';
?>

<div class="page-heading">
    <div>
        <span class="badge-soft status-active mb-2">
            <i class="bi bi-grid-1x2-fill me-1"></i>
            <?= $isAdmin ? __('HEP Administration') : __('Student Portal') ?>
        </span>
        <h1><?= $isAdmin ? __('Administration Dashboard') : __('Student Dashboard') ?></h1>
        <p><?= __('Welcome back, {0}. Here is the latest e-KAP activity.', h($fullName)) ?></p>
    </div>

    <div class="page-actions">
        <?php if ($isStudent): ?>
            <?= $this->Html->link(
                '<i class="bi bi-plus-circle"></i>' . __('New Application'),
                ['controller' => 'Applications', 'action' => 'add'],
                ['class' => 'button', 'escape' => false]
            ) ?>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
            <?= $this->Html->link(
                '<i class="bi bi-people"></i>' . __('Register New Club'),
                ['controller' => 'Clubs', 'action' => 'add'],
                ['class' => 'button', 'escape' => false]
            ) ?>
        <?php endif; ?>

        <?= $this->Html->link(
            '<i class="bi bi-file-earmark-text"></i>' . __('View Applications'),
            ['controller' => 'Applications', 'action' => 'index'],
            ['class' => 'button button-outline', 'escape' => false]
        ) ?>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php
    $statCards = [
        ['key' => 'total', 'label' => __('Total Applications'), 'icon' => 'bi-folder2-open', 'class' => 'stat-total'],
        ['key' => 'submitted', 'label' => __('Submitted'), 'icon' => 'bi-send-check', 'class' => 'stat-submitted'],
        ['key' => 'under_review', 'label' => __('Under Review'), 'icon' => 'bi-hourglass-split', 'class' => 'stat-review'],
        ['key' => 'approved', 'label' => __('Approved'), 'icon' => 'bi-patch-check', 'class' => 'stat-approved'],
        ['key' => 'rejected', 'label' => __('Rejected'), 'icon' => 'bi-x-octagon', 'class' => 'stat-rejected'],
    ];
    ?>

    <?php foreach ($statCards as $card): ?>
        <div class="col-12 col-sm-6 col-lg">
            <div class="dashboard-card h-100 p-3 p-lg-4">
                <div class="d-flex align-items-start justify-content-between gap-3">
                    <div>
                        <p class="text-secondary small mb-2"><?= h($card['label']) ?></p>
                        <strong class="display-6 fw-bold"><?= h((string)($counts[$card['key']] ?? 0)) ?></strong>
                    </div>
                    <span class="dashboard-stat-icon <?= h($card['class']) ?>">
                        <i class="bi <?= h($card['icon']) ?>"></i>
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-12 col-xl-9">
        <div class="dashboard-table p-3 p-lg-4 h-100">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="h5 mb-1"><?= __('Recent Applications') ?></h2>
                    <p class="small text-secondary mb-0"><?= __('The five most recently updated applications.') ?></p>
                </div>

                <?= $this->Html->link(
                    __('View all') . '<i class="bi bi-arrow-right ms-1"></i>',
                    ['controller' => 'Applications', 'action' => 'index'],
                    ['class' => 'small fw-semibold', 'escape' => false]
                ) ?>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th><?= __('Reference') ?></th>
                            <th><?= __('Programme') ?></th>
                            <?php if ($isAdmin): ?>
                                <th><?= __('Student') ?></th>
                            <?php endif; ?>
                            <th><?= __('Club') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($recentApplications) === 0): ?>
                            <tr>
                                <td colspan="<?= $isAdmin ? 7 : 6 ?>" class="text-center text-secondary py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    <?= __('No applications have been created.') ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($recentApplications as $application): ?>
                            <?php
                            $applicationStatus = $application->status ?? 'draft';
                            $statusLabel = ucwords(str_replace('_', ' ', $applicationStatus));
                            ?>
                            <tr>
                                <td><?= h($application->reference_no ?: 'Draft') ?></td>
                                <td><strong><?= h($application->program_title ?: '-') ?></strong></td>
                                <?php if ($isAdmin): ?>
                                    <td><?= h($application->user->full_name ?? '-') ?></td>
                                <?php endif; ?>
                                <td><?= h($application->club->club_name ?? '-') ?></td>
                                <td><?= $application->start_datetime ? h($application->start_datetime->format('d M Y')) : '-' ?></td>
                                <td>
                                    <span class="status status-<?= h($applicationStatus) ?>"><?= h($statusLabel) ?></span>
                                </td>
                                <td>
                                    <?= $this->Html->link(
                                        '<i class="bi bi-eye"></i>' . __('View'),
                                        ['controller' => 'Applications', 'action' => 'view', $application->id],
                                        ['class' => 'small fw-semibold', 'escape' => false]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-3">
        <div class="content p-3 p-lg-4 h-100">
            <h2 class="h5 mb-3"><?= __('Quick Access') ?></h2>

            <div class="d-grid gap-2">
                <?= $this->Html->link(
                    '<i class="bi bi-person-circle"></i>' . __('My Profile'),
                    ['controller' => 'Users', 'action' => 'view', $auth['id']],
                    ['class' => 'button button-outline justify-content-start', 'escape' => false]
                ) ?>

                <?= $this->Html->link(
                    '<i class="bi bi-people"></i>' . ($isAdmin ? __('Manage Clubs') : __('View Clubs')),
                    ['controller' => 'Clubs', 'action' => 'index'],
                    ['class' => 'button button-outline justify-content-start', 'escape' => false]
                ) ?>

                <?php if ($isAdmin): ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-person-gear"></i>' . __('Manage Users'),
                        ['controller' => 'Users', 'action' => 'index'],
                        ['class' => 'button button-outline justify-content-start', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
