<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Icon" class="auth-icon">
            <h1>Dein Profil</h1>
            <p>Verwalte deine E-Mail-Adresse und dein Passwort.</p>
        </div>

        <?php if (!empty($_SESSION['user_message'])): ?>
            <?= $_SESSION['user_message']; unset($_SESSION['user_message']); ?>
        <?php endif; ?>

        <form method="post" action="?controller=user&action=update" class="auth-form">
            <label for="email">E-Mail-Adresse</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($user->getEmail() ?? 'NO_USER', ENT_QUOTES) ?>"
                   required>

            <label for="current_password">Aktuelles Passwort <span class="small-hint">(zur Bestätigung)</span></label>
            <input type="password" id="current_password" name="current_password" placeholder="Zur Bestätigung eingeben">

            <label for="new_password">Neues Passwort <span class="small-hint">(leer lassen, wenn nicht ändern)</span></label>
            <input type="password" id="new_password" name="new_password" placeholder="Neues Passwort eingeben">

            <label for="confirm_password">Neues Passwort bestätigen</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <button type="submit">💾 Speichern</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
