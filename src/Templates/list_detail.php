<?php include __DIR__ . '/header.php'; ?>

<main class="list-detail-wrap">
    <section class="list-detail-card">
        <h1><?= $list['title'] ?? '📝 Einkaufsliste' ?></h1>

        <ul class="list-items">
            <?php foreach ($list['items'] as $item): ?>
                <li>
                    <span><?= htmlspecialchars($item['name']) ?></span>
                    <span class="qty"><?= htmlspecialchars($item['quantity']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="btn-center">
            <a href="?controller=shopping&action=index" class="back-btn">🔙 Zurück zur Übersicht</a>
        </div>

    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
