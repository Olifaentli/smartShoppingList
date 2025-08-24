<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <h1>📝 Neue Einkaufsliste</h1>
            <p>Erstelle eine neue Liste mit Namen.</p>
        </div>

        <form action="?controller=list&action=create" method="post" class="auth-form">
            <label for="name"><strong>Name *</strong></label>
            <input type="text" id="name" name="name" required>

            <button type="submit">➕ Liste erstellen</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>