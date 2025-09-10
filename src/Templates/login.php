<?php include __DIR__ . '/header.php';
?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Warenkorb Icon" class="auth-icon">
            <h1>Login</h1>
            <p>Melde dich an, um deine smarte Einkaufsliste zu verwalten.</p>
            <?php if (!empty($_GET['success'])): ?>
                <p style="color: green; font-weight: bold; text-align: center;">
                    ✅ Registrierung erfolgreich. Du kannst dich jetzt einloggen.
                </p>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <p class="message-error"><?= htmlspecialchars($this->translate($error)) ?></p>
            <?php endif; ?>

        </div>

        <form action="?controller=login&action=login" method="post" class="auth-form">
            <label for="email">E-Mail-Adresse</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Anmelden</button>
        </form>

        <p class="auth-switch">
            Noch keinen Account? <a href="?controller=register&action=template">Jetzt registrieren</a>
        </p>

        <p class="fun-text">🔒 Dein Kühlschrank verrät nichts – deine Daten auch nicht!</p>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>