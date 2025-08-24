<?php include __DIR__ . '/header.php'; ?>

<main class="list-detail-wrap">
    <section class="list-detail-card">
        <h1><?= $list['title'] ?? '📝 Einkaufsliste' ?></h1>

        <h2>📝 Einträge</h2>

        <?php if (empty($items)): ?>
        <p>Keine Einträge vorhanden.</p>
        <?php else: ?>
            <ul class="list-items">
                <?php foreach ($items as $item): ?>
                    <li>
                        <span><?= htmlspecialchars($item->getName()) ?></span>
                        <span class="qty">
                            <?= $item->getAmount() ?> <?= $item->getUnit() ?>
                            <?php if ($item->getComment()): ?>
                                <em>(<?= htmlspecialchars($item->getComment()) ?>)</em>
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
a
        <div class="btn-center">
            <a href="?controller=shopping&action=index" class="back-btn">🔙 Zurück zur Übersicht</a>
        </div>

    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>




