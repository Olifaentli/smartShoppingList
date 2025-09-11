# SmartShoppingList

SmartShoppingList ist eine PHP-Anwendung zur Verwaltung von Einkaufslisten. Sie nutzt Composer für Abhängigkeiten und eine relationale Datenbank (z\.B\. MySQL).

## Voraussetzungen

- PHP >= 8.0
- Composer
- MySQL oder eine andere relationale Datenbank

## Installation

1. Repository klonen: git clone <REPO-URL> cd smartshoppinglist
2. Abhängigkeiten installieren: composer install
3. Umgebungsvariablen konfigurieren (z\.B\. `.env`-Datei anlegen basierend auf dem env.example).
4. Datenbank einrichten: SQL-Skripte im Ordner `sql/` ausführen.


## Nutzung

- Lokalen Server starten: php -S localhost:8000 -t public
- Anwendung im Browser öffnen: http://localhost:8000

## Projektstruktur

- `src/` – Quellcode (Controller, Model, Repository)
- `sql/` – SQL-Skripte für die Datenbank
- `vendor/` – Composer-Abhängigkeiten
