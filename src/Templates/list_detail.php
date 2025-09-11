<?php include __DIR__ . '/header.php'; ?>
<main class="list-detail-wrap">
    <section class="list-detail-card">
        <h1><?= $list->getName() ?? '📝 Einkaufsliste' ?></h1>

        <h2>📝 Einträge</h2>

        <?php if (empty($items)): ?>
        <p>Keine Einträge vorhanden.</p>
        <?php else: ?>
            <!-- Offene Einträge -->
            <ul class="list-items">
                <?php foreach ($items as $item): ?>
                    <?php if (!$item->isChecked()): ?>
                        <li>
                <span>
                    <span class="qty">
                        <?= htmlspecialchars($item->getAmount()) . ' ' . htmlspecialchars($item->getUnit()) ?>
                    </span>
                    <?= htmlspecialchars($item->getName()) ?>
                    <?php if ($item->getComment()): ?>
                        <small class="subtext"> — <?= htmlspecialchars($item->getComment()) ?></small>
                    <?php endif; ?>
                </span>

                            <form method="post" action="index.php?controller=list&action=checkItem" style="margin:0;">
                                <input type="hidden" name="item_id" value="<?= $item->getId() ?>">
                                <input type="hidden" name="list_id" value="<?= $list->getId() ?>">
                                <button type="submit" class="btn-open" aria-label="Abhaken">✓</button>
                            </form>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <?php
            $hasChecked = false;
            foreach ($items as $it) { if ($it->isChecked()) { $hasChecked = true; break; } }
            ?>

            <?php if ($hasChecked): ?>
                <h3>Erledigt</h3>
                <ul class="list-items">
                    <?php foreach ($items as $item): ?>
                        <?php if ($item->isChecked()): ?>
                            <li class="checked">
                    <span>
                        <span class="qty">
                            <?= htmlspecialchars($item->getAmount()) . ' ' . htmlspecialchars($item->getUnit()) ?>
                        </span>
                        <?= htmlspecialchars($item->getName()) ?>
                        <?php if ($item->getComment()): ?>
                            <small class="subtext"> — <?= htmlspecialchars($item->getComment()) ?></small>
                        <?php endif; ?>
                    </span>
                                <!-- kein Button bei erledigten Einträgen -->
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
        <h2>➕ Neuen Eintrag hinzufügen</h2>
        <form action="?controller=list&action=addItem" method="POST" class="add-item-form">
            <input type="hidden" name="list_id" value="<?= (int) $listId ?>">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="amount">Menge:</label>
            <input type="text" id="amount" name="amount">

            <label for="unit">Einheit:</label>
            <select id="unit" name="unit">
                <option value="">– keine –</option>
                <option value="stk">Stk</option>
                <option value="kg">kg</option>
                <option value="g">g</option>
                <option value="l">l</option>
                <option value="ml">ml</option>
                <option value="pack">Pack</option>
                <option value="dose">Dose</option>
                <option value="bund">Bund</option>
            </select>

            <label for="comment">Kommentar:</label>
            <input type="text" id="comment" name="comment">

            <button type="submit">✅ Hinzufügen</button>
        </form>
        <div class="btn-center">
            <a href="?controller=list&action=index" class="back-btn">🔙 Zurück zur Übersicht</a>
        </div>

    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>




