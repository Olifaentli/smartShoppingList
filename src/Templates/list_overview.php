<?php include __DIR__ . '/header.php'; ?>

<main class="shopping-wrap">
    <section class="shopping-card">
        <h1>Deine Einkaufslisten</h1>
        <p>Wähle eine Liste, um sie anzuzeigen oder zu bearbeiten.</p>

        <?php if (empty($lists)): ?>
            <p>Keine Einträge vorhanden.</p>
        <?php else: ?>
            <ul class="list-overview">
                <?php foreach ($lists as $list): ?>
                    <li class="list-box">
                        <span class="list-title"><?= htmlspecialchars($list->getName()) ?></span>
                        <div class="list-actions" style="display:flex; gap:.5rem; align-items:center;">
                            <a class="btn-open" href="?controller=list&action=detail&id=<?= $list->getId() ?>">Öffnen</a>

                            <a class="btn-edit" href="?controller=list&action=edit&id=<?= $list->getId() ?>">Umbenennen</a>

                            <form method="post" action="?controller=list&action=delete"
                                  onsubmit="return confirm('Liste wirklich löschen?');" style="margin:0;">
                                <input type="hidden" name="id" value="<?= $list->getId() ?>">
                                <button type="submit" class="btn-danger">Löschen</button>
                            </form>
                            <button type="button" class="btn-copy" onclick="copyJoinLink(<?= $list->getId() ?>)">
                                🔗 Link kopieren
                            </button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="btn-center">
            <a href="?controller=list&action=create" class="btn-create">
                ➕ Neue Einkaufsliste
            </a>
            <a href="?controller=list&action=aiForm" class="btn-ai">
                🤖 KI-Generator
            </a>
        </div>

<script>
    function copyJoinLink(listId) {
        const joinUrl = `${window.location.origin}/index.php?controller=list&action=join&list_id=${listId}`;
        navigator.clipboard.writeText(joinUrl).then(() => {
            alert("Join-Link kopiert!");
        }).catch(err => {
            console.error("Fehler beim Kopieren:", err);
            alert("Konnte den Link nicht kopieren.");
        });
    }
</script>

<?php include __DIR__ . '/footer.php'; ?>
