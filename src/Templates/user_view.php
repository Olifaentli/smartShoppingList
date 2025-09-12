<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <i class="bi bi-person-circle auth-icon"></i>
            <h1><?= $this->translate('profile_title') ?></h1>
            <p><?= $this->translate('profile_subtitle') ?></p>
        </div>

        <?php if (!empty($_SESSION['user_message'])): ?>
            <div class="message-box">
                <?= $_SESSION['user_message']; unset($_SESSION['user_message']); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="?controller=user&action=update" class="auth-form">
            <label for="email"><?= $this->translate('email_label') ?></label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($user->getEmail() ?? 'NO_USER', ENT_QUOTES) ?>"
                   required>

            <label for="current_password"><?= $this->translate('current_password_label') ?>
                <span class="small-hint">(<?= $this->translate('current_password_hint') ?>)</span>
            </label>
            <input type="password" id="current_password" name="current_password">

            <label for="new_password"><?= $this->translate('new_password_label') ?>
                <span class="small-hint">(<?= $this->translate('new_password_hint') ?>)</span>
            </label>
            <input type="password" id="new_password" name="new_password">

            <label for="confirm_password"><?= $this->translate('confirm_password_label') ?></label>
            <input type="password" id="confirm_password" name="confirm_password">

            <div class="btn-center">
                <button type="submit" class="btn-create">
                    <i class="bi bi-save"></i> <?= $this->translate('save_button') ?>
                </button>
                <a href="?controller=home&action=template" class="btn-back">
                    <i class="bi bi-x-circle"></i> <?= $this->translate('cancel_button') ?>
                </a>
            </div>

            <div class="btn-center">
                <a href="?controller=list&action=index" class="btn-create">
                    <i class="bi bi-list-check"></i> <?= $this->translate('back_to_lists') ?>
                </a>
            </div>

        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
