<?php include __DIR__ . '/header.php'; ?>

<main class="list-detail-wrap">
    <section class="shopping-card">
        <h1><i class="bi bi-card-checklist"></i> <?= htmlspecialchars($list->getName()) ?></h1>

        <h2><i class="bi bi-list-task"></i> <?= $this->translate('list_items_title') ?></h2>

        <?php if (empty($items)): ?>
            <p class="subtext"><?= $this->translate('no_items') ?></p>
        <?php else: ?>
            <ul class="list-items">
                <?php foreach ($items as $item): ?>
                    <?php if (!$item->isChecked()): ?>
                        <li>
                            <span>
                                <span class="qty"><?= htmlspecialchars($item->getAmount()) . ' ' . htmlspecialchars($item->getUnit()) ?></span>
                                <?= htmlspecialchars($item->getName()) ?>
                                <?php if ($item->getComment()): ?>
                                    <small class="subtext"> — <?= htmlspecialchars($item->getComment()) ?></small>
                                <?php endif; ?>
                            </span>
                            <form method="post" action="?controller=list&action=checkItem" class="inline-form">
                                <input type="hidden" name="item_id" value="<?= $item->getId() ?>">
                                <input type="hidden" name="list_id" value="<?= $list->getId() ?>">
                                <button type="submit" class="btn-open" aria-label="<?= $this->translate('mark_done') ?>">
                                    <i class="bi bi-check2-circle"></i>
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <?php if (array_filter($items, fn($i) => $i->isChecked())): ?>
                <h3><i class="bi bi-check-all"></i> <?= $this->translate('done_title') ?></h3>
                <ul class="list-items">
                    <?php foreach ($items as $item): ?>
                        <?php if ($item->isChecked()): ?>
                            <li class="checked">
                                <span>
                                    <span class="qty"><?= htmlspecialchars($item->getAmount()) . ' ' . htmlspecialchars($item->getUnit()) ?></span>
                                    <?= htmlspecialchars($item->getName()) ?>
                                    <?php if ($item->getComment()): ?>
                                        <small class="subtext"> — <?= htmlspecialchars($item->getComment()) ?></small>
                                    <?php endif; ?>
                                </span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <h2><i class="bi bi-plus-circle"></i> <?= $this->translate('add_item') ?></h2>
        <form action="?controller=list&action=addItem" method="POST" class="add-item-form">
            <input type="hidden" name="list_id" value="<?= (int) $listId ?>">

            <label for="name"><?= $this->translate('item_name') ?></label>
            <input type="text" id="name" name="name" required>

            <label for="amount"><?= $this->translate('item_amount') ?></label>
            <input type="text" id="amount" name="amount">

            <label for="unit"><?= $this->translate('item_unit') ?></label>
            <select id="unit" name="unit">
                <option value=""><?= $this->translate('unit_none') ?></option>
                <option value="stück"><?= $this->translate('unit_piece') ?></option>
                <option value="kg"><?= $this->translate('unit_kilogram') ?></option>
                <option value="gramm"><?= $this->translate('unit_gram') ?></option>
                <option value="liter"><?= $this->translate('unit_liter') ?></option>
                <option value="ml"><?= $this->translate('unit_milliliter') ?></option>
                <option value="cm"><?= $this->translate('unit_centimeter') ?></option>
                <option value="meter"><?= $this->translate('unit_meter') ?></option>
            </select>

            <label for="comment"><?= $this->translate('item_comment') ?></label>
            <input type="text" id="comment" name="comment">

            <button type="submit" class="btn-create">
                <i class="bi bi-plus-circle"></i> <?= $this->translate('add_button') ?>
            </button>
        </form>

        <div class="btn-center">
            <a href="?controller=list&action=index" class="btn-back">
                <i class="bi bi-arrow-left"></i> <?= $this->translate('back_to_overview') ?>
            </a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>