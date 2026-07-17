<?php
/**
 * e-KAP application layout.
 *
 * @var \App\View\AppView $this
 */

$auth = $this->request->getSession()->read('Auth') ?? [];
$isLoggedIn = !empty($auth);
$isAdmin = ($auth['role'] ?? '') === 'admin';
$isStudent = ($auth['role'] ?? '') === 'student';
$currentController = (string)$this->request->getParam('controller');
$currentAction = (string)$this->request->getParam('action');
$isAuthPage = $currentController === 'Users' && in_array($currentAction, ['login', 'register'], true);
$homeUrl = $isLoggedIn ? '/dashboard' : '/login';
$pageTitle = trim((string)$this->fetch('title')) ?: 'e-KAP';

$isActive = static function (string $controller, ?string $action = null) use ($currentController, $currentAction): string {
    if ($currentController !== $controller) {
        return '';
    }

    if ($action !== null && $currentAction !== $action) {
        return '';
    }

    return ' active';
};
?>
<!doctype html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f5f4f">
    <title><?= h($pageTitle) ?> | e-KAP</title>

    <?= $this->Html->meta('icon', '/img/ekap-logo-nav.png') ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <?= $this->Html->css('ekap') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="<?= $isAuthPage ? 'auth-body' : 'app-body' ?>">
    <nav class="navbar navbar-expand-lg ekap-navbar sticky-top" aria-label="Primary navigation">
        <div class="container-xl">
            <a class="navbar-brand ekap-brand" href="<?= h($this->Url->build($homeUrl)) ?>" aria-label="Return to dashboard">
                <?= $this->Html->image('ekap-logo-nav.png', [
                    'alt' => 'e-KAP home',
                    'class' => 'ekap-brand-logo',
                ]) ?>
                <span class="ekap-brand-copy">
                    <strong>e-KAP</strong>
                    <small>Electronic Kelulusan Aktiviti Pelajar</small>
                </span>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#ekapPrimaryNav"
                aria-controls="ekapPrimaryNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="ekapPrimaryNav">
                <?php if ($isLoggedIn): ?>
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link<?= $isActive('Dashboard') ?>" href="<?= h($this->Url->build('/dashboard')) ?>">
                                <i class="bi bi-house-door"></i>
                                <?= __('Dashboard') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= $isActive('Applications') ?>" href="<?= h($this->Url->build(['controller' => 'Applications', 'action' => 'index'])) ?>">
                                <i class="bi bi-file-earmark-text"></i>
                                <?= __('Applications') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= $isActive('Clubs') ?>" href="<?= h($this->Url->build(['controller' => 'Clubs', 'action' => 'index'])) ?>">
                                <i class="bi bi-people"></i>
                                <?= $isAdmin ? __('Manage Clubs') : __('Clubs') ?>
                            </a>
                        </li>

                        <?php if ($isAdmin): ?>
                            <li class="nav-item">
                                <a class="nav-link<?= $isActive('Users') ?>" href="<?= h($this->Url->build(['controller' => 'Users', 'action' => 'index'])) ?>">
                                    <i class="bi bi-person-gear"></i>
                                    <?= __('Users') ?>
                                </a>
                            </li>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link" href="<?= h($this->Url->build(['controller' => 'Clubs', 'action' => 'add'])) ?>">
                                    <i class="bi bi-plus-circle"></i>
                                    <?= __('Register New Club') ?>
                                </a>
                            </li>
                        <?php elseif ($isStudent): ?>
                            <li class="nav-item">
                                <a class="nav-link<?= $currentController === 'Applications' && $currentAction === 'add' ? ' active' : '' ?>" href="<?= h($this->Url->build(['controller' => 'Applications', 'action' => 'add'])) ?>">
                                    <i class="bi bi-plus-circle"></i>
                                    <?= __('New Application') ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <div class="nav-user ms-lg-3 mt-3 mt-lg-0">
                        <a class="nav-user-profile" href="<?= h($this->Url->build(['controller' => 'Users', 'action' => 'view', $auth['id']])) ?>">
                            <span class="nav-user-avatar">
                                <?= h(mb_strtoupper(mb_substr((string)($auth['full_name'] ?? 'U'), 0, 1))) ?>
                            </span>
                            <span class="nav-user-copy">
                                <strong><?= h($auth['full_name'] ?? 'User') ?></strong>
                                <small><?= h(ucfirst((string)($auth['role'] ?? 'user'))) ?></small>
                            </span>
                        </a>
                        <?= $this->Form->postLink(
                            '<i class="bi bi-box-arrow-right"></i><span class="visually-hidden">' . __('Logout') . '</span>',
                            '/logout',
                            [
                                'escape' => false,
                                'class' => 'nav-logout',
                                'confirm' => __('Are you sure you want to log out?'),
                                'title' => __('Logout'),
                            ]
                        ) ?>
                    </div>
                <?php else: ?>
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item">
                            <a class="nav-link<?= $currentAction === 'login' ? ' active' : '' ?>" href="<?= h($this->Url->build('/login')) ?>">
                                <?= __('Login') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-ekap btn-sm px-3" href="<?= h($this->Url->build('/register')) ?>">
                                <?= __('Register') ?>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="<?= $isAuthPage ? 'auth-main' : 'app-main' ?>">
        <div class="<?= $isAuthPage ? 'container-fluid p-0' : 'container-xl py-4 py-lg-5' ?>">
            <div class="flash-stack">
                <?= $this->Flash->render() ?>
            </div>
            <?= $this->fetch('content') ?>
        </div>
    </main>

    <footer class="ekap-footer">
        <div class="container-xl">
            <div class="footer-grid">
                <div class="footer-brand">
                    <?= $this->Html->image('ekap-logo-nav.png', [
                        'alt' => 'e-KAP',
                        'class' => 'footer-logo',
                    ]) ?>
                    <div>
                        <strong>e-KAP</strong>
                        <span><?= __('Electronic Kelulusan Aktiviti Pelajar') ?></span>
                    </div>
                </div>
                <div class="footer-copy">
                    <span>© <?= date('Y') ?> Universiti Teknologi MARA</span>
                    <span><?= __('UiTM Puncak Perdana') ?></span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
    <?= $this->Html->script('ekap') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
