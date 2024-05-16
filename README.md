# Zammad API Schnittstelle
API Anbindung zum [Ticket System Zammad](https://zammad.com/) über ein eigenes Gateway des Notification Centers.

## Beschreibung
Über die Schnittstelle können Formulardaten direkt als neues Ticket an Zammad gesendet werden. Falls ein Kontakt in Zammad nicht gefunden wird, wird dieser ebenfalls erzeugt. Im Nachrichtentext können beliebige Daten anhand von Simple Tokens ergänzt werden.

> [!IMPORTANT]  
> Die Version 3.* ist nicht mit den Vorgängerversionen kompatibel. Bei einem Update von 2.* auf 3.* muss die Erweiterung neu konfiguriert werden.

## Dokumentation
Eine ausführliche Doku findest Du hier: https://www.fenepedia.de/tools/zammad-connector

## Schnellstart-Anleitung
1. In Zammad ein neuen Zugriffstoken generieren: User > Profil > Token-Zugriff > Erstellen (Berechtigung: `ticket.agent`)
2. Notification Center > Neues Gateway vom Typ Zammad-API (Host + Token hinterlegen)
3. Neue Benachrichtigung (z. B. Formularübergragung)
4. Neue Nachricht erstellen: Gateway = Zammad
5. Pflichtfelder ausfüllen: E-Mail, Ticket-Betreff, Ticket-Gruppe, Nachrichtentext (Simple Token möglich: `##form_feldname##` )
6. Kunden-Parameter bei Bedarf ergänzen (Empfehlung: `firstname`, `lastname`)

## Zuordnung der Formularfelder
Ab Version 3.0 findet die Zuordnung der Felder über Simple Tokens statt. Anbei noch eine Liste von bekannten Feldnamen für die Kundendaten:
* firstname = Vorname
* lastname = Nachname
* mobile = Mobilnummer
* phone = Telefonnummer
* fax = Faxnummer
* web = Website
* address = Adresse
* department = Abteilung
* street = Straße
* zip = Postleitzahl
* city = Stadt
* Country = Land
* note = Notiz


## Welche Version soll ich installieren?

| Contao Version  | PHP Version        | NC-Version         | Zammad-Erweiterung   |
|-----------------|--------------------|--------------------|-------------------------|
| 4.9 \|\| 4.13     | 7.*                | 1.6.*            | 2.*                   |
| 4.13.* \|\| 5.*   | \>= ^8.1           | 2.*              | 3.*                     |


## Unterstützer:innen

Die Entwicklung der Erweiterung wurde von den folgenden Personen bzw. Unternehmen ermöglicht:
- Fritz Michael Gschwantner | [inspiredminds](https://www.inspiredminds.at/)
- [Alexander Naumov](https://alexandernaumov.de/)
- Christian Feneberg | [Contao Academy](https://contao-academy.de/)

