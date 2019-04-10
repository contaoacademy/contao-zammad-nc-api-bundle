# contao-zammad-nc-api
API Anbindung zum [Ticket System Zammad](https://zammad.com/) über ein Gateway des Notification-Center

## Beschreibung
Die Schnittstelle sendet Formulardaten direkt als neues Ticket an Zammad.
Falls ein Kontakt in Zammad nicht angelegt ist, wird dieser ebenfalls erzeugt.


## Konfiguration
1. System > Einstellungen > Zammad-Einstellungen (Host, Benutzer, Passwort)
2. Notification Center > Neues Gateway vom Typ Zammad-API
3. Neue Benachrichtigung (z.B. Formularübergragung)
4. Neue Nachricht erstellen: Gateway = Zammad und Zammad Gruppe hinterlegen
5. Benachrichtigung zuordnen: Formulargenerator > Formular > Benachrichtigung auswählen

## Zuordnung der Formularfelder
Damit die Zuordnung korrekt funktioniert, müssen die Formularfelder bestimmte Namen haben:
* firstname = Vorname
* lastname = Nachname
* email = E-Mail-Adresse
* body = Ticket Inhalt
* mobile = Mobilnummer
* phone = Telefonnummer
* web = Website
* address = Adresse
* note = Notiz
* department = Abteilung

Im Body wird automatisch der *Alias* der Seite ergänzt.
Weitere Felder im Formular werden automatisch am Ende des Tickets dem Body hinzugefügt.

## Credits
* Programmierung: https://alexandernaumov.de/
* Auftraggeber: https://contao-academy.de/
