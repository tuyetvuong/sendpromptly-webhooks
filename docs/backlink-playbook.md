---
title: Backlink Playbook
canonical_path: /docs/guides/
---

# Backlink playbook (GitHub as a link magnet)

GitHub links are often `nofollow`, so the goal is:
**use this repo as a high-trust reference implementation** that earns *external* links to:
- this repo (as the “code reference”), and
- `sendpromptly.com` (as the canonical guide + product)

## 1) “Awesome list” PRs (fast, relevant)
Targets:
- Awesome Webhooks list: https://github.com/realadeel/awesome-webhooks

Angle:
- Add this repo under “Security” or “Reliability” with a one-line description:
  “Signature cookbook + test vectors + idempotency inbox pattern (Laravel/Node/Python).”

## 2) Dev.to / Hashnode deep-dive posts (high intent)
Post idea:
- “The Idempotent Inbox: how to never process a webhook twice”

Link structure:
- GitHub repo → “full code + test vectors”
- SendPromptly docs → “canonical explanation + operational runbooks”

## 3) StackOverflow: answer first, link second
Pattern:
- Provide the full snippet in the answer (avoid spam flags).
- Then add: “Full test vectors and middleware examples: <repo link>”

## 4) Show HN / Product Hunt (launch the *resource*, not the product)
See: `docs/launch-kit.md`

## 5) Link-out to authoritative resources (helps categorization)
See: `docs/related-resources.md`
