# Release 2.1.0 PR Notes

## Summary

This branch prepares Divi Accessibility `2.1.0` as a broad compatibility and modernization release. The work focuses on shipping Divi 5 support without regressing Divi 4, while also fixing the release pipeline so the packaged plugin reflects the actual branch state.

## What Changed

- added Divi 5 Visual Builder support for the existing module-level `Accessibility Settings` group
- preserved Divi 4 module-level toggle behavior and frontend compatibility
- added mobile menu screen-reader isolation while the menu is open
- added reduced motion support
- improved slider arrow/dot accessibility and increased slider dot touch target sizing
- improved accessible naming for search and cart controls
- improved contact form async announcements and checkbox keyboard accessibility
- added plugin-owned Divi 4/5 compatibility styling
- fixed package contents, version metadata sync, and npm lint coverage

## Verification

- `npm run lint`
- `npm run build`
- `npm run i18n`
- package zip generation and zip content inspection
- targeted `php -l` and `node --check`
- manual visual pass:
  - frontend tabs working
  - Divi 5 Visual Builder modules display `Accessibility Settings`

## Still Needs Integration Review

- packaged plugin install/activate check in WordPress
- Divi 4 frontend smoke test
- Divi 5 frontend smoke test
- Divi 5 Visual Builder persistence check for the two module-level toggles
- migrated D4-to-D5 content check for legacy accessibility attrs
