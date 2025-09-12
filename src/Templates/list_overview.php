<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1><i class="bi bi-list-check"></i> <?= $this->translate('overview_title') ?></h1>
        <p><?= $this->translate('overview_subtitle') ?></p>

        <?php if (empty($lists)): ?>
            <p class="subtext"><?= $this->translate('no_lists') ?></p>
        <?php else: ?>
            <ul class="list-overview">
                <?php foreach ($lists as $list): ?>
                    <?php
                    $isShared = method_exists($list, 'isShared')
                        ? $list->isShared($this->getCurrentUser()->getId())
                        : false;
                    $cssClass = $isShared ? 'list-box shared' : 'list-box personal';
                    ?>
                    <li class="<?= $cssClass ?>">
                        <span class="list-title"><?= htmlspecialchars($list->getName()) ?></span>
                        <div class="list-actions">
                            <a class="btn-icon" href="?controller=list&action=detail&id=<?= $list->getId() ?>" title="<?= $this->translate('open_button') ?>">
                                <i class="bi bi-folder2-open"></i>
                            </a>
                            <a class="btn-icon" href="?controller=list&action=edit&id=<?= $list->getId() ?>" title="<?= $this->translate('rename_button') ?>">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post" action="?controller=list&action=delete" onsubmit="return confirm('<?= $this->translate('confirm_delete') ?>');" style="margin:0;">
                                <input type="hidden" name="id" value="<?= $list->getId() ?>">
                                <button type="submit" class="btn-icon btn-danger" title="<?= $this->translate('delete_button') ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <button type="button" class="btn-icon" onclick="copyJoinLink(<?= $list->getId() ?>)" title="<?= $this->translate('copy_link') ?>">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="btn-center">
            <a href="?controller=list&action=create" class="btn-create">
                <i class="bi bi-plus-circle"></i> <?= $this->translate('new_list_button') ?>
            </a>
            <a href="?controller=list&action=aiForm" class="btn-ai">
                <i class="bi bi-robot"></i> <?= $this->translate('ai_generator_button') ?>
            </a>
        </div>
    </section>
</main>

<script>
    function copyJoinLink(listId) {
        const joinUrl = `${window.location.origin}/index.php?controller=list&action=join&list_id=${listId}`;
        navigator.clipboard.writeText(joinUrl).then(() => {
            alert("<?= $this->translate('copy_success') ?>");
        }).catch(err => {
            console.error("Fehler beim Kopieren:", err);
            alert("<?= $this->translate('copy_error') ?>");
        });
    }
</script>

<?php include __DIR__ . '/footer.php'; ?>
