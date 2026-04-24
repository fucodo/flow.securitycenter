### Data Model: `ActivityLogEntry`

This table describes the data model for `ActivityLogEntry` including its embeddable objects.

| Property | Type | Embeddable / Relation | Description |
| :--- | :--- | :--- | :--- |
| `createdAt` | `DateTimeImmutable` | - | Date and time when the log entry was created. |
| `expiresAt` | `DateTimeImmutable` | - | Date and time when the log entry expires. |
| `userIdentity` | `string` | - | Identifier of the user associated with this entry. |
| `title` | `string` | - | Title of the log entry. |
| `message` | `string` | - | Detailed message of the log entry. |
| `code` | `string` | - | A specific code identifying the type of event. |
| `severity` | `string` | - | Severity level (Notice, Warning, Error, OK). |
| `userApproval` | `ApprovalEmbeddable` | Yes | Approval details required from the user. |
| `adminApproval` | `ApprovalEmbeddable` | Yes | Approval details required from an administrator. |
| `networkAddress` | `NetworkAddressEmbeddable` | Yes | Information about the network address (IP, hostname). |
| `device` | `DeviceEmbeddable` | Yes | Details about the device used (Browser, OS, Model). |
| `source` | `string?` | - | Source of the log entry (e.g., 'internal'). |
| `sourceIdentifier`| `string?` | - | Identifier for the specific source. |
| `parentLogEntry` | `ActivityLogEntry` | ManyToOne | Reference to a parent log entry, if applicable. |
| `userRequestedCheckBySupport` | `ApprovalEmbeddable` | Yes | Status of a support check requested by the user. |
| `webHookAfterRelease` | `string` | - | URL to be called after the entry is released. |

---

#### Embeddable: `ApprovalEmbeddable`

Used for `userApproval`, `adminApproval`, and `userRequestedCheckBySupport`.

| Property | Type | Description |
| :--- | :--- | :--- |
| `needed` | `bool` | Whether an approval/action is required. |
| `doneAt` | `DateTimeImmutable?` | When the approval/action was completed. |
| `signalUri` | `string` | URI used to signal back the result of the action. |
| `doneBy` | `string` | Identifier of who performed the action. |

---

#### Embeddable: `NetworkAddressEmbeddable`

Used for `networkAddress`.

| Property | Type | Description |
| :--- | :--- | :--- |
| `ipAdress` | `string` | The IP address. |
| `resolvedHostnames` | `string` | Hostname(s) resolved from the IP address. |

---

#### Embeddable: `DeviceEmbeddable`

Used for `device`.

| Property | Type | Description |
| :--- | :--- | :--- |
| `clientFamily` | `string` | Browser or client family (e.g., Chrome, Firefox). |
| `clientVersion` | `string` | Version of the client. |
| `clientEngine` | `string` | Rendering engine of the client. |
| `osFamily` | `string` | Operating system family (e.g., Windows, macOS, Linux). |
| `osVersion` | `string` | Version of the operating system. |
| `osInfo` | `string` | Additional information about the OS. |
| `deviceName` | `string` | Name of the device. |
| `brandName` | `string` | Brand of the device (e.g., Apple, Samsung). |
| `model` | `string` | Model of the device. |
| `bot` | `bool?` | Indicates if the request was made by a bot. |

---
---

### Datenmodell: `ActivityLogEntry` (German Translation)

Diese Tabelle beschreibt das Datenmodell für `ActivityLogEntry` einschließlich der eingebetteten Objekte (Embeddables).

| Eigenschaft | Typ | Embeddable / Beziehung | Beschreibung |
| :--- | :--- | :--- | :--- |
| `createdAt` | `DateTimeImmutable` | - | Datum und Uhrzeit der Erstellung des Log-Eintrags. |
| `expiresAt` | `DateTimeImmutable` | - | Datum und Uhrzeit, zu dem der Log-Eintrag abläuft. |
| `userIdentity` | `string` | - | Identifikator des mit diesem Eintrag verknüpften Benutzers. |
| `title` | `string` | - | Titel des Log-Eintrags. |
| `message` | `string` | - | Detaillierte Nachricht des Log-Eintrags. |
| `code` | `string` | - | Ein spezifischer Code, der den Ereignistyp identifiziert. |
| `severity` | `string` | - | Schweregrad (Notice, Warning, Error, OK). |
| `userApproval` | `ApprovalEmbeddable` | Ja | Erforderliche Freigabedetails vom Benutzer. |
| `adminApproval` | `ApprovalEmbeddable` | Ja | Erforderliche Freigabedetails von einem Administrator. |
| `networkAddress` | `NetworkAddressEmbeddable` | Ja | Informationen zur Netzwerkadresse (IP, Hostname). |
| `device` | `DeviceEmbeddable` | Ja | Details zum verwendeten Gerät (Browser, OS, Modell). |
| `source` | `string?` | - | Quelle des Log-Eintrags (z. B. 'internal'). |
| `sourceIdentifier`| `string?` | - | Identifikator für die spezifische Quelle. |
| `parentLogEntry` | `ActivityLogEntry` | ManyToOne | Verweis auf einen übergeordneten Log-Eintrag, falls vorhanden. |
| `userRequestedCheckBySupport` | `ApprovalEmbeddable` | Ja | Status einer vom Benutzer angeforderten Support-Prüfung. |
| `webHookAfterRelease` | `string` | - | URL, die nach der Freigabe des Eintrags aufgerufen werden soll. |

---

#### Embeddable: `ApprovalEmbeddable`

Wird für `userApproval`, `adminApproval` und `userRequestedCheckBySupport` verwendet.

| Eigenschaft | Typ | Beschreibung |
| :--- | :--- | :--- |
| `needed` | `bool` | Gibt an, ob eine Freigabe/Aktion erforderlich ist. |
| `doneAt` | `DateTimeImmutable?` | Zeitpunkt, zu dem die Freigabe/Aktion abgeschlossen wurde. |
| `signalUri` | `string` | URI, die zur Rückmeldung des Ergebnisses der Aktion verwendet wird. |
| `doneBy` | `string` | Identifikator der Person, die die Aktion durchgeführt hat. |

---

#### Embeddable: `NetworkAddressEmbeddable`

Wird für `networkAddress` verwendet.

| Eigenschaft | Typ | Beschreibung |
| :--- | :--- | :--- |
| `ipAdress` | `string` | Die IP-Adresse. |
| `resolvedHostnames` | `string` | Aus der IP-Adresse aufgelöste Hostnamen. |

---

#### Embeddable: `DeviceEmbeddable`

Wird für `device` verwendet.

| Eigenschaft | Typ | Beschreibung |
| :--- | :--- | :--- |
| `clientFamily` | `string` | Browser- oder Client-Familie (z. B. Chrome, Firefox). |
| `clientVersion` | `string` | Version des Clients. |
| `clientEngine` | `string` | Rendering-Engine des Clients. |
| `osFamily` | `string` | Betriebssystemfamilie (z. B. Windows, macOS, Linux). |
| `osVersion` | `string` | Version des Betriebssystems. |
| `osInfo` | `string` | Zusätzliche Informationen zum Betriebssystem. |
| `deviceName` | `string` | Name des Geräts. |
| `brandName` | `string` | Marke des Geräts (z. B. Apple, Samsung). |
| `model` | `string` | Modell des Geräts. |
| `bot` | `bool?` | Gibt an, ob die Anfrage von einem Bot stammt. |
