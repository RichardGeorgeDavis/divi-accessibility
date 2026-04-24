# Release 2.1.0 PR Notes

## Status

Do not use these notes for upstream review yet. Final runtime verification is still required before this document can be treated as the reviewer-facing summary.

Current upstream PR:
- `#121` <https://github.com/campuspress/divi-accessibility/pull/121>

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
- fixed the undefined `tota11y` default path reported in issue `#90`

## Verification

- `npm run lint`
- `npm run build`
- `npm run i18n`
- `npm run release`
- package zip generation and zip content inspection
- packaged-plugin install, activate, deactivate, and reactivate smoke check on LocalWP:
  - WordPress `6.9.4`
  - Divi `5.3.3`
  - frontend response includes Divi Accessibility `2.1.0` payload
- targeted `php -l` and `node --check`
- manual visual pass:
  - frontend tabs working
  - Divi 5 Visual Builder modules display `Accessibility Settings`
- focused follow-up verification:
  - `php -l public/class-divi-accessibility-public.php` after the `tota11y` fix

## Still Needs Integration Review

- Divi 4 frontend smoke test
- Divi 5 frontend smoke test
- Divi 5 Visual Builder persistence check for the two module-level toggles
- migrated D4-to-D5 content check for legacy accessibility attrs
- navbar/submenu visibility and announcement check related to upstream issue `#122`
- maintainer closure of upstream issue `#90` after reviewing the now-landed fix in `#121`

## Final Runtime Results

Pending manual verification. Update this section only after the packaged-plugin checks and Divi 4/5 runtime matrix are complete.

## Handover Notes

- draft tester comments are already posted on `#121`
- refreshed downloadable prerelease test build is prepared for the fork:
  - <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/codex-2.1.0-rc2>
  - SHA-256: `b9e550840eb807e5d35e4dfc154c24c084f20caf864baf31280616f52c0ff6fc`
- older `codex-2.1.0-rc1` build should be treated as superseded
- takeover/adoption package is documented in `docs/takeover-adoption-package.md`
- AFK batch evidence is documented in `docs/afk-batch-2026-04-24.md`
