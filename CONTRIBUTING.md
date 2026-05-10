# Contributing

Thanks for helping improve Divi Accessibility.

## Current Project Status

This repository is a maintained fork release path while official upstream and
WordPress.org ownership are unresolved. The original plugin was created by
CampusPress. Keep original contributor credit intact and avoid language that
claims official continuity unless ownership or committer access is granted.

## Before Opening Work

- Search existing issues and pull requests first.
- Keep changes scoped to one clear bug, compatibility fix, or documentation
  improvement.
- For accessibility fixes, include the user impact and the specific interaction
  that changes.
- For Divi compatibility fixes, include WordPress, Divi, plugin, and browser
  versions when possible.

## Local Development

Install dependencies:

```bash
npm install
```

Run lint checks:

```bash
npm run lint
```

Build minified assets:

```bash
npm run build
```

Build a test package:

```bash
npm run package
```

The package and `.sha256` checksum file are written to `packaged/`.

## Pull Request Expectations

- Keep GPL-compatible licensing.
- Do not relicense existing plugin code to MIT.
- Preserve CampusPress and existing contributor credit.
- Update `README.md`, `readme.txt`, and release notes when behavior changes.
- Regenerate minified assets when editing files under `public/partials/js` or
  `public/partials/css`.
- Include runtime verification notes for frontend accessibility behavior when
  practical.

## Accessibility Testing Notes

Useful checks include:

- Keyboard-only navigation.
- Screen-reader announcement of names, roles, states, and live regions.
- Mobile menu open/close state and focus behavior.
- Divi 4 and Divi 5 frontend behavior.
- Visual Builder save/reopen persistence for module settings.
