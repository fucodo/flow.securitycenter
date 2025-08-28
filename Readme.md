# Securitycenter 

* adds a security center to a kaystrobach.backend application

## Usage

* just composer req the lib

## External libraries

* https://github.com/matomo-org/device-detector

## Functionality

* hooks into repositories to log changes
* allows to track logins and login failures per user

# Securitycenter

* adds a security center to a kaystrobach.backend application

## Usage

* just composer req the lib

## External libraries

* https://github.com/matomo-org/device-detector

## Functionality

* hooks into repositories to log changes
* allows to track logins and login failures per user

## Konzept

------------------------------------------------------------------------------------------------------------------------------------------------------------

# Security Center Logging System

## Inhaltsverzeichnis
1. [Einleitung](#einleitung)
2. [Features](#features)
3. [Installationsanleitung](#installationsanleitung)
4. [Event- / Slot-Pattern](#event--slot-pattern)
5. [Datenmodell](#datenmodell)
6. [Beispielimplementierung](#beispielimplementierung)
7. [Konfiguration](#konfiguration)
8. [Nutzung](#nutzung)
9. [Erweiterbarkeit](#erweiterbarkeit)
10. [Troubleshooting](#troubleshooting)

---

## Einleitung
Das Security Center Logging System ist ein Werkzeug zur Protokollierung und Analyse von sicherheitsrelevanten Aktivitäten.
Es ermöglicht es, verdächtige Ereignisse zu erfassen, zu kategorisieren und geeignete Aktionen basierend auf festgelegten Regeln zu initiieren.

## Features
- **Kategorisierung von Aktivitäten**: Aktivitäten werden mit vier Schweregraden klassifiziert (`Notice`, `Warning`, `Error`, `OK`).
- **Erweiterbares Event- / Slot-Pattern**: Ermöglicht das Hinzufügen spezifischer Ereignisse und zugehöriger Aktionen.
- **Datenpersistenz**: Unterstützt Speicherung mit Entity-Klassen und eingebetteten Objekten.
- **Benutzer- und Admin-Interaktion**: Verwaltung von Benutzer- und Admin-Genehmigungen.
- **Unterstützung mehrerer Datenquellen**: Aktivitäten können aus internen oder externen Quellen kommen.

## Installationsanleitung
1. Installieren Sie die benötigten PHP-Abhängigkeiten mittels Composer:
   ```bash
   composer install
   ```
2. Fügen Sie die Konfiguration für die Berechtigungen die `Policy.yaml` hinzu.
3. Führen Sie Migrationen aus, um die Datenbanktabellen zu erstellen:
   ```bash
   ./flow doctrine:migrate
   ```
4. Stellen Sie sicher, dass der Signal-Slot-Dispatcher aktiviert ist.

## Event- / Slot-Pattern
Das Logging-System nutzt das Event- / Slot-Pattern, um Aktivitäten zu erfassen.
Das `Signal-Slot`-Modul wird verwendet, um Ereignisse mit Listenern zu verbinden.

* https://flowframework.readthedocs.io/en/8.4/TheDefinitiveGuide/PartIII/SignalsAndSlots.html

### Beispiel: Login-Tracking
- **Signal**: Ein Benutzer wird authentifiziert.
- **Slot**: Ein Log-Eintrag wird erstellt.

### Verbindung:
```php
$dispatcher->connect(
    AuthenticationProviderManager::class,
    'authenticatedToken',
    LoginSlot::class,
    'trackLogin'
);
```

## Datenmodell
Die zentrale Klasse ist `ActivityLogEntry`. Sie speichert die Details zu einer Aktivität.

### Attribute:
- **`severity`**: Schweregrad der Aktivität (`Notice`, `Warning`, `Error`, `OK`).
- **`createdAt`**: Zeitpunkt der Erstellung.
- **`expiresAt`**: Zeitpunkt der Löschung.
- **`title`**: Titel der Aktivität.
- **`message`**: Menschenlesbare Notizen oder Hinweise aus dem System
- **`code`**: Nummer des Fehlers / Nachrichtentyps
- **`userIdentity`**: Benutzerkennung.
- **`networkAddress`**: IP-Adresse und Netzwerkdetails (bestehend aus IP-Adresse und Hostname).
- **`device`**: Gerätedetails (bestehend aus clientFamily, clientVersion, clientEngine, osFamily, osInfo, osVersion, deviceName, brandName, model, bot).
  https://github.com/matomo-org/device-detector
- **`parentLogEntry`**: Referenz zu einem vorherigen Log-Eintrag (für verknüpfte Ereignisse).
- **`source`**: Meistens `internal` kann aber auch ein externe Webhook für andere Anwendungen sein.
- **`sourceIdentifier'**: Technischer Identifier der Quelle.
- **`data`**: Zusärtliche Technische Daten als Information
- **`reviewNotes`**: Menschenlesbare Notizen oder Hinweise nach einem Review

Zusätzlich werden noch die folgenden Prüfungsanfragen erfasst:

- **`userApproval`**: Nutzer soll das Ereignis bestätigen / prüfen
- **`adminApproval`**: Admin / Support soll das Ereignis bestätigen / prüfen

Zu jeder Prüfungsanfrage werden die folgenden Daten erfasst:

- **`needed`**: Prüfung erforderlich?
- **`doneAt`**: Wann erfolgte die Prüfung
- **`signalUri`**: Externer Dienst, der bei Statusänderung informiert werden soll
- **`doneBy`**: Externer Dienst, der bei Statusänderung informiert werden soll

## Backendmodul für Nutzer

Das System bietet ein Backendmodul, in dem Benutzer alle mit ihnen verbundenen Log-Einträge einsehen können.
Hierbei werden detaillierte Informationen zu den Aktivitäten angezeigt, wie z. B. Zeitpunkt, Schweregrad und Beschreibung.
Benutzer haben die Möglichkeit, eine Überprüfung durch den Support anzufordern, indem sie direkt in der Oberfläche eine Review-Anfrage erstellen.
Das Modul stellt Filter- und Suchfunktionen bereit, um spezifische Einträge schnell zu finden.

## Backendmodul für Support und Administration

Ein zweites Modul ist speziell für Administratoren konzipiert.
Es ermöglicht den Admins, alle eingereichten Review-Anfragen von Benutzern einzusehen und diese zu bearbeiten.
Administratoren können den Status der Anfragen ändern, Kommentare hinzufügen und gegebenenfalls Maßnahmen ergreifen.
Das Modul bietet eine klare Übersicht über alle offenen und abgeschlossenen Anfragen sowie Filtermöglichkeiten, um nach Schweregrad oder Benutzer zu sortieren.
Dadurch wird ein effizienter und strukturierter Bearbeitungsprozess gewährleistet.

## Beispielimplementierung
### LoginSlot:
```php
public function trackLogin(TokenInterface $token): void
{
    $identifier = $token->getAccount()->getAccountIdentifier();
    $log = new ActivityLogEntry();
    $log->setTitle('Login');
    $log->setSeverity(ActivityLogEntry::SEVERITY_NOTICE);
    $log->setUserIdentity($identifier);
    $this->persistenceManager->allowObject($log);
    $this->persistenceManager->add($log);
    $this->persistenceManager->persistAllowedObjects();
}
```

## Konfiguration
Konfigurieren Sie den Dispatcher in der `Package.php`:
```php
$dispatcher->connect(
    AuthenticationProviderManager::class,
    'authenticatedToken',
    LoginSlot::class,
    'trackLogin'
);
```
## Löschung

Jeder Eintrag enthält ein **`expiresAt`** Attribut.
Einträge deren Ablaufdatum erreicht ist werden regelmäßig durch einen Hintergrundjob gelöscht.
Es kann zusätzlich in der Konfiguration ein maximaler Zeitraum bis zum Ablauf angegeben werden. Kein Einträg kann älter
werden, als diese Angabe.

## Nutzung
1. Implementieren Sie neue Slots für benutzerdefinierte Ereignisse.
2. Binden Sie die Slots an Signale über den Dispatcher.
3. Überprüfen Sie die Log-Einträge im entsprechenden Datenbank-Repository.

## Erweiterbarkeit
- **Neue Ereignisse hinzufügen**: Implementieren Sie zusätzliche Slots und verbinden Sie diese mit relevanten Signalen.
- **Anpassung von Log-Daten**: Passen Sie die `ActivityLogEntry`-Klasse an, um zusätzliche Felder zu unterstützen.
- **Hooks**: Eingehende und Ausgehende Webhooks für weitere Anbindungen

## Troubleshooting
- **Keine Logs erstellt**: Überprüfen Sie, ob der Dispatcher korrekt konfiguriert ist.
- **Datenbankfehler**: Vergewissern Sie sich, dass die Migrationen erfolgreich durchgeführt wurden.
- **Fehlerhafte Slots**: Stellen Sie sicher, dass die Methoden-Signaturen der Slots korrekt mit den Signalen übereinstimmen.

## Fixes

Replace Proxy Objects with their correspondig implementation

```sql
UPDATE sbs_singlesignon_commands_cleaner_domain_model_recordmark_cb34f
SET recordtype = REPLACE(recordtype, 'Neos\\Flow\\Persistence\\Doctrine\\Proxies\\__CG__\\', '')
WHERE recordtype LIKE '%Proxies%';
```

Find duplicates after cleanup

```sql
SELECT recordtype, recordidentifier, COUNT(*)
FROM sbs_singlesignon_commands_cleaner_domain_model_recordmark_cb34f
GROUP BY recordtype, recordidentifier
HAVING COUNT(*) > 1
```

Cleanup Duplicates (run multiple times)

```sql
DELETE FROM sbs_singlesignon_commands_cleaner_domain_model_recordmark_cb34f
WHERE persistence_object_identifier IN (
    SELECT u.persistence_object_identifier
    FROM sbs_singlesignon_commands_cleaner_domain_model_recordmark_cb34f u, sbs_singlesignon_commands_cleaner_domain_model_recordmark_cb34f u2
    WHERE u.recordtype = u2.recordtype AND u.recordidentifier = u2.recordidentifier AND u.created > u2.created
)
```
