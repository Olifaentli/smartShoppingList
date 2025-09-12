<?php include __DIR__ . '/header.php'; ?>

<main class="auth-wrap">
    <section class="auth-card">
        <div class="auth-head">
            <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" alt="Roboter Icon" class="auth-icon">
            <h1>🤖 Menü-Generator</h1>
            <p>Erzeuge eine smarte Einkaufsliste basierend auf deinen Vorgaben.</p>
        </div>

        <form action="?controller=list&action=aiGenerate" method="post" class="auth-form">

            <label for="persons">Anzahl Personen*</label>
            <input type="number" id="persons" name="persons" min="1" required>

            <label for="meals">Anzahl Mahlzeiten*</label>
            <input type="number" id="meals" name="meals" min="1" required>

            <label for="cuisine">Küchenrichtung</label>
            <select id="cuisine" name="cuisine">
                <option value="">Keine Präferenz</option>
                <option value="italienisch">Italienisch</option>
                <option value="asiatisch">Asiatisch</option>
                <option value="schweizerisch">Schweizerisch</option>
                <option value="mexikanisch">Mexikanisch</option>
            </select>

            <label for="budget">Budget (CHF)</label>
            <input type="text" id="budget" name="budget" placeholder="z.B. 80">

            <div class="checkbox-group">
                <label><input type="checkbox" name="vegetarian"> Vegetarisch</label>
                <label><input type="checkbox" name="vegan"> Vegan</label>
            </div>

            <label for="allergies">Allergien / Unverträglichkeiten</label>
            <input type="text" id="allergies" name="allergies" placeholder="z.B. Erdnüsse, Laktose">

            <label for="dislikes">Ausschlüsse</label>
            <input type="text" id="dislikes" name="dislikes" placeholder="z.B. Pilze, Oliven">

            <label for="notes">Zusatzwünsche</label>
            <textarea id="notes" name="notes" rows="3" placeholder="z.B. schnell kochbar, 1x ohne Kochen, Reste nutzbar"></textarea>

            <button type="submit" class="btn-create">🤖 KI-Menü erstellen</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>