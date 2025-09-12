<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <i class="bi bi-person-plus auth-icon"></i>
            <h1><?= $this->translate('register_title') ?></h1>
            <p><?= $this->translate('register_subtitle') ?></p>
            <?php if (!empty($errorMessage)): ?>
                <p class="message-error">
                    <i class="bi bi-exclamation-circle"></i>
                    <?= $this->translate($errorMessage) ?>
                </p>
            <?php endif; ?>
        </div>

        <form action="?controller=register&action=register" method="post" class="auth-form">
            <label for="email"><?= $this->translate('email_label') ?></label>
            <input type="email" id="email" name="email" required>

            <label for="password"><?= $this->translate('password_label') ?></label>
            <input type="password" id="password" name="password" required>

            <button type="submit">
                <i class="bi bi-person-plus"></i> <?= $this->translate('register_button') ?>
            </button>

            <p class="auth-switch">
                <?= $this->translate('already_have_account') ?>
                <a href="?controller=login&action=template"><?= $this->translate('login_link') ?></a>
            </p>
            <p class="fun-text"><?= $this->translate('fun_fact_register') ?></p>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
