<?php include __DIR__ . '/header.php'; ?>

    <main class="auth-wrap">
        <section class="auth-card">
            <div class="auth-head">
                <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Warenkorb Icon" class="auth-icon">
                <h1>Registrierung</h1>
                <p>Erstelle dein Konto für die smarte Einkaufsliste.</p>
                <?php if (!empty($error)): ?>
                    <p class="message-error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

            </div>

            <form action="?controller=register&action=register" method="post" class="auth-form">
                <label for="email">E-Mail-Adresse</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Registrieren</button>

                <p class="fun-text">💡 Wusstest du? Die meisten Leute vergessen Knoblauch auf der Liste 🧄</p>
            </form>
        </section>
    </main>

<?php include __DIR__ . '/footer.php'; ?>