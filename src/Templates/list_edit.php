<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1><i class="bi bi-pencil-square"></i> <?= $this->translate('rename_list_title') ?></h1>
        <p class="subtext"><?= $this->translate('rename_list_subtext') ?></p>

        <form method="post" action="?controller=list&action=update" class="auth-form">

            <input type="hidden" name="id" value="<?= $list->getId() ?>">

            <label for="name"><?= $this->translate('new_list_name') ?></label>
            <input id="name" name="name" type="text" value="<?= htmlspecialchars($list->getName()) ?>" required>

            <div class="btn-center">
                <button type="submit" class="btn-create">
                    <i class="bi bi-check-circle"></i> <?= $this->translate('save_button') ?>
                </button>
                <a href="?controller=list&action=index" class="btn-back">
                    <i class="bi bi-x-circle"></i> <?= $this->translate('cancel_button') ?>
                </a>
            </div>

        </form>

    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
