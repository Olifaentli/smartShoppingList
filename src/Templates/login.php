<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <i class="bi bi-box-arrow-in-right auth-icon"></i>
            <h1><?= $this->translate('login_title') ?></h1>
            <p><?= $this->translate('login_subtitle') ?></p>

            <?php if (!empty($_SESSION['user_message'])): ?>
                <?= $_SESSION['user_message']; unset($_SESSION['user_message']); ?>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <p class="message-error">
                    <i class="bi bi-exclamation-circle"></i> <?= $this->translate($error) ?>
                </p>
            <?php endif; ?>
        </div>

        <form action="?controller=login&action=login" method="post" class="auth-form">
            <label for="email"><?= $this->translate('email_label') ?></label>
            <input type="email" id="email" name="email" required>

            <label for="password"><?= $this->translate('password_label') ?></label>
            <input type="password" id="password" name="password" required>

            <button type="submit">
                <i class="bi bi-box-arrow-in-right"></i> <?= $this->translate('login_button') ?>
            </button>
        </form>

        <p class="auth-switch">
            <?= $this->translate('no_account') ?>
            <a href="?controller=register&action=template"><?= $this->translate('register_link') ?></a>
        </p>

        <p class="fun-text"><?= $this->translate('fun_fact_login') ?></p>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
