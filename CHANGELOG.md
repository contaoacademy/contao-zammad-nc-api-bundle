# Zammad Gateway Changelog

## 3.3.0 (unreleased)

**New features:**

 * Add file attachment support via NotificationCenter file tokens — uploaded form
   files (e.g. `##form_upload##`) are attached to the created Zammad ticket.

## 3.2.0 (2026-07-07)

**New features:**

 * Add an optional "send as HTML" toggle per message (`content_type: text/html`
   vs. `text/plain`).

## 3.1.1 (2025-04-01)

**Fixed issues:**

 * Improve code style.

## 3.1.0 (2025-04-01)

**New features:**

 * Change the ticket header from `X-On-Behalf-Of` to `From`.

**Fixed issues:**

 * Query the customer by e-mail only and match exactly, without surrounding quotes.

## 3.0.1 (2024-08-14)

**Fixed issues:**

 * Fix a Haste 5.2+ compatibility issue and unlock Symfony 7.

## 3.0.0 (2024-05-13)

**New features:**

 * Rewrite the gateway for Notification Center 2.x.
