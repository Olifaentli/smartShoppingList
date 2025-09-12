<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <i class="bi bi-robot auth-icon"></i>
            <h1><?= $this->translate('ai_generator_title') ?></h1>
            <p><?= $this->translate('ai_generator_subtitle') ?></p>
        </div>

        <form action="?controller=list&action=aiGenerate" method="post" class="auth-form">

            <label for="persons"><?= $this->translate('ai_persons_label') ?>*</label>
            <input type="number" id="persons" name="persons" min="1" required>

            <label for="meals"><?= $this->translate('ai_meals_label') ?>*</label>
            <input type="number" id="meals" name="meals" min="1" required>

            <label for="cuisine"><?= $this->translate('ai_cuisine_label') ?></label>
            <select id="cuisine" name="cuisine">
                <option value=""><?= $this->translate('ai_cuisine_none') ?></option>
                <option value="italienisch"><?= $this->translate('ai_cuisine_italian') ?></option>
                <option value="asiatisch"><?= $this->translate('ai_cuisine_asian') ?></option>
                <option value="schweizerisch"><?= $this->translate('ai_cuisine_swiss') ?></option>
                <option value="mexikanisch"><?= $this->translate('ai_cuisine_mexican') ?></option>
            </select>

            <label for="budget"><?= $this->translate('ai_budget_label') ?></label>
            <input type="text" id="budget" name="budget" placeholder="<?= $this->translate('ai_budget_placeholder') ?>">

            <div class="checkbox-group">
                <label><input type="checkbox" name="vegetarian"> <?= $this->translate('ai_vegetarian') ?></label>
                <label><input type="checkbox" name="vegan"> <?= $this->translate('ai_vegan') ?></label>
            </div>

            <label for="allergies"><?= $this->translate('ai_allergies_label') ?></label>
            <input type="text" id="allergies" name="allergies" placeholder="<?= $this->translate('ai_allergies_placeholder') ?>">

            <label for="dislikes"><?= $this->translate('ai_dislikes_label') ?></label>
            <input type="text" id="dislikes" name="dislikes" placeholder="<?= $this->translate('ai_dislikes_placeholder') ?>">

            <label for="notes"><?= $this->translate('ai_notes_label') ?></label>
            <textarea id="notes" name="notes" rows="3" placeholder="<?= $this->translate('ai_notes_placeholder') ?>"></textarea>

            <div class="btn-center">
                <button type="submit" class="btn-create">
                    <i class="bi bi-magic"></i> <?= $this->translate('ai_generate_button') ?>
                </button>
                <a href="?controller=list&action=index" class="btn-back">
                    <i class="bi bi-arrow-left"></i> <?= $this->translate('back_to_overview') ?>
                </a>
            </div>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
