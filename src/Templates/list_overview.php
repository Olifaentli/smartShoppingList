<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1>Deine Einkaufslisten</h1>
        <p>Wähle eine Liste, um sie anzuzeigen oder zu bearbeiten.</p>

        <?php if (empty($lists)): ?>
            <p>Keine Einträge vorhanden.</p>
        <?php else: ?>
            <ul class="list-overview">
                <?php foreach ($lists as $list): ?>
                    <li class="list-box">
                        <span class="list-title"><?= htmlspecialchars($list->getName()) ?></span>
                        <a class="btn-open" href="?controller=list&action=detail&id=<?= $list->getId() ?>">
                            Öffnen
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="btn-center">
            <a href="?controller=list&action=create" class="btn-create">
                ➕ Neue Einkaufsliste
            </a>
        </div>

    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
