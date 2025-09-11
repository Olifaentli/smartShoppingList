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
        </div>
        <form class="ai-form" method="post" action="?controller=list&action=aiGenerate" style="margin-top:1.25rem; padding:1rem; border:1px solid #eee; border-radius:.75rem;">
            <h2 style="margin-top:0;">🍳 Menü-Generator (KI)</h2>
            <p style="margin: .25rem 0 1rem 0; color:#555;">Erzeuge eine neue Liste basierend auf deinen Vorgaben.</p>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:.75rem;">
                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Personen</span>
                    <input type="number" name="persons" min="1" value="2" required>
                </label>

                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Anzahl Mahlzeiten</span>
                    <input type="number" name="meals" min="1" value="5" required>
                </label>

                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Küche (optional)</span>
                    <select name="cuisine">
                        <option value="">Keine Präferenz</option>
                        <option>Mediterran</option>
                        <option>Asiatisch</option>
                        <option>Mexikanisch</option>
                        <option>Indisch</option>
                        <option>Schweizerisch</option>
                    </select>
                </label>

                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Budget grob (CHF, optional)</span>
                    <input type="number" name="budget" min="0" step="1" placeholder="z.B. 80">
                </label>
            </div>

            <div style="display:flex; gap:1rem; align-items:center; margin-top:.75rem;">
                <label style="display:flex; align-items:center; gap:.5rem;">
                    <input type="checkbox" name="vegetarian"> Vegetarisch
                </label>
                <label style="display:flex; align-items:center; gap:.5rem;">
                    <input type="checkbox" name="vegan"> Vegan
                </label>
            </div>

            <div style="display:grid; grid-template-columns: 1fr; gap:.75rem; margin-top:.75rem;">
                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Allergien/Unverträglichkeiten (Komma-getrennt)</span>
                    <input type="text" name="allergies" placeholder="z.B. Erdnüsse, Laktose">
                </label>

                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Mag ich nicht / Ausschlüsse (Komma-getrennt)</span>
                    <input type="text" name="dislikes" placeholder="z.B. Pilze, Oliven">
                </label>

                <label style="display:flex; flex-direction:column; gap:.25rem;">
                    <span>Zusatzwünsche (optional)</span>
                    <textarea name="notes" rows="3" placeholder="z.B. schnell kochbar, 1x ohne Kochen, Resten nutzbar"></textarea>
                </label>
            </div>

            <!-- Falls du eine Basisliste als Kontext verwenden willst, kannst du hier optional ein Select einbauen.
                 Wir setzen standardmässig 0 (kein Kontext). -->
            <input type="hidden" name="base_list_id" value="0">

            <div style="margin-top:1rem; display:flex; gap:.5rem; flex-wrap:wrap;">
                <button type="submit" class="btn-create">✨ KI-Menü erstellen</button>
                <small style="color:#777;">Es wird eine <strong>neue</strong> Einkaufsliste erstellt.</small>
            </div>
        </form>
    </section>
</main>

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
