<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1>Dein Profil</h1>

        <?php if (!empty($_SESSION['user_message'])): ?>
            <div><?= $_SESSION['user_message']; unset($_SESSION['user_message']); ?></div>
        <?php endif; ?>

        <form method="post" action="?controller=user&action=update" class="profile-form">
            <div class="form-row">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($user->getEmail() ?? 'NO_USER', ENT_QUOTES) ?>"
                       required>
            </div>

            <hr>

            <div class="form-row">
                <label for="current_password">Aktuelles Passwort</label>
                <input type="password" id="current_password" name="current_password"
                       placeholder="Zur Bestätigung eingeben">
            </div>

            <div class="form-row">
                <label for="new_password">Neues Passwort</label>
                <input type="password" id="new_password" name="new_password"
                       placeholder="Leer lassen, wenn du es nicht ändern willst">
            </div>

            <div class="form-row">
                <label for="confirm_password">Neues Passwort bestätigen</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Speichern</button>
            </div>
        </form>
    </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>