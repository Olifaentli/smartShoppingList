<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1>Liste umbenennen</h1>
        <p class="subtext">Ändere den Namen deiner Einkaufsliste.</p>

        <form method="post" action="?controller=list&action=update" class="add-item-form" style="max-width:480px;">
            <input type="hidden" name="id" value="<?= $list->getId() ?>">
            <label for="name">Neuer Listenname</label>
            <input id="name" name="name" type="text" value="<?= htmlspecialchars($list->getName()) ?>" required>
            <button type="submit">Speichern</button>
            <a class="btn-back" href="?controller=list&action=index" style="margin-left:.5rem;">Abbrechen</a>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
