<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <i class="bi bi-list-task auth-icon"></i>
            <h1><?= $this->translate('new_list_title') ?></h1>
            <p><?= $this->translate('new_list_subtitle') ?></p>
        </div>

        <form action="?controller=list&action=create" method="post" class="auth-form">
            <label for="name"><?= $this->translate('list_name_label') ?> *</label>
            <input type="text" id="name" name="name" required>

            <div class="btn-center">
                <button type="submit" class="btn-create">
                    <i class="bi bi-plus-circle"></i> <?= $this->translate('create_list_button') ?>
                </button>
                <a href="?controller=list&action=index" class="btn-back">
                    <i class="bi bi-x-circle"></i> <?= $this->translate('cancel_button') ?>
                </a>
            </div>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
