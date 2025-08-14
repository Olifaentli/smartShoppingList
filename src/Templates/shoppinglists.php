<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1>🗂 Deine Einkaufslisten</h1>
        <p>Wähle eine Liste, um sie anzuzeigen oder zu bearbeiten.</p>

        <ul class="list-overview">
            <li>
                <span> Wochenplan</span>
                <a href="?controller=list&action=detail&id=1" class="btn-list-open">Öffnen</a>
            </li>
            <li>
                <span> Pasta-Party</span>
                <a href="?controller=list&action=detail&id=2" class="btn-list-open">Öffnen</a>
            </li>
            <li>
                <span> Vorräte auffüllen</span>
                <a href="?controller=list&action=detail&id=3" class="btn-list-open">Öffnen</a>
            </li>
        </ul>

        <div class="btn-center">
            <a href="?controller=list&action=create" class="btn-create">
                ➕ Neue Einkaufsliste
            </a>
        </div>


    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
