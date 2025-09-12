<?php include __DIR__ . '/header.php'; ?>

<main class="home-wrap">
    <section class="home-card">
        <h1>👋 <?= $this->translate('home_welcome') ?></h1>
        <p><?= $this->translate('home_intro') ?></p>

        <ul class="feature-list">
            <li>🧠 <?= $this->translate('feature_ai') ?></li>
            <li>🥦 <?= $this->translate('feature_reuse') ?></li>
            <li>💸 <?= $this->translate('feature_budget') ?></li>
            <li>👨‍👩‍👧‍👦 <?= $this->translate('feature_groups') ?></li>
        </ul>

        <a href="?controller=login&action=template" class="home-btn">
            <?= $this->translate('login_now') ?>
        </a>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
