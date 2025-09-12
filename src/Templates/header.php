<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?= $this->translate('app_name') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="Css/style.css">
</head>
<body>
<header class="topbar">
    <div class="logo">
        <a href="?controller=home&action=template">
            <i class="bi bi-cart-check-fill"></i> <?= $this->translate('app_name') ?>
        </a>
    </div>
    <div class="topbar-actions">
        <?php if ($this->getCurrentUser()): ?>
            <a href="?controller=user&action=template" class="avatar-btn">
                <i class="bi bi-person-circle"></i>
            </a>
            <a href="?controller=login&action=logout" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> <?= $this->translate('logout') ?>
            </a>
        <?php endif; ?>
    </div>
</header>