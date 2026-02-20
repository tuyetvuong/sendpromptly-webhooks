# Contributing

Thanks for improving the SendPromptly reference kit.

## What we accept
- Additional language examples (Go, Ruby, Rust, C#)
- Improved test vectors (newline, unicode, large payloads)
- Documentation clarity improvements (typos, diagrams, checklists)

## What we don’t accept
- Changes that claim to be canonical API behavior unless they link to SendPromptly docs

## Style
- Keep snippets **copy/paste friendly**
- Always sign using **raw body**
- Prefer constant-time comparisons

## PR checklist
- [ ] Updated docs page (if behavior changes)
- [ ] Added/updated tests or vectors
- [ ] Ran `python3 scripts/verify_test_vectors.py`
