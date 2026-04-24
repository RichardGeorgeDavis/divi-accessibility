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
- fixed submenu focus state so visible keyboard-opened submenus also report `aria-expanded="true"`
- fixed tabs keyboard navigation so old panels are reset to `aria-hidden="true"` inside the current tabs module
- fixed mobile-menu screen-reader isolation for Divi Pixel hamburger markup by syncing from the actual open menu state and observing third-party menu class changes
- added `#et-main-area` fallback support for skip links, main landmark assignment, and mobile-menu screen-reader isolation when templates do not include `#main-content`
- improved contact form async announcements and checkbox keyboard accessibility
- added plugin-owned Divi 4/5 compatibility styling
- fixed package contents, version metadata sync, and npm lint coverage
- fixed the undefined `tota11y` default path reported in issue `#90`
- normalized release metadata for the maintained-fork path without relicensing away from GPL compatibility

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
  - `php -l divi-accessibility.php` and `php -l admin/class-divi-accessibility-admin.php` after metadata cleanup
  - Divi 5 packaged-plugin browser pass for issue `#122`:
    - focused parent menu opens submenu and sets `aria-expanded="true"`
    - Escape closes submenu and restores `aria-expanded="false"`
    - mobile-menu screen-reader isolation still opens and restores correctly
  - Divi 5 packaged-plugin browser pass on a local Divi 5 module test page:
    - sliders expose labeled keyboard controls and active-dot state
    - contact-form invalid submit syncs field invalid state and live-region attributes
    - toggles/accordions expose button semantics and matching expanded state
    - tabs keyboard navigation syncs selected tab and panel `aria-hidden` state
  - Divi Pixel alternate mobile-header browser pass on local Divi Pixel test site A:
    - `divi-accessibility` `2.1.0` and `divi-pixel` `2.50.0` are active
    - mobile menu opens and closes without Divi Accessibility console errors
    - opened menu sets `aria-expanded="true"` and hides `#main-content` and `#et-main-area` from screen readers
    - closed menu removes plugin-managed `aria-hidden`
  - second local Divi 5 / Divi Pixel / WooCommerce browser sweep:
    - active target plugins are `divi-accessibility` `2.1.0`, `divi-pixel` `2.50.1`, and `woocommerce` `10.7.0`
    - all 17 published pages returned HTTP `200`
    - 14 normal Divi pages loaded `_da11y.version` `2.1.0`, skip link, `role="main"`, and labelled mobile controls
    - Cart, Checkout, and Shop render WooCommerce store-only/coming-soon output without the normal footer scripts, so no footer-enqueued plugin JS runs on those responses
    - homepage Divi Pixel mobile-menu open/close passes with `aria-expanded` sync and content isolation

## Still Needs Integration Review

- Divi 4 frontend smoke test
- Divi 5 frontend smoke test
- Divi 5 Visual Builder persistence check for the two module-level toggles
- migrated D4-to-D5 content check for legacy accessibility attrs
- search/cart behavior on alternate header/menu configurations; Divi Pixel mobile-menu isolation is covered on two local Divi Pixel test sites
- maintainer closure of upstream issue `#90` after reviewing the now-landed fix in `#121`

## Final Runtime Results

Pending manual verification. Update this section only after the packaged-plugin checks and Divi 4/5 runtime matrix are complete.

## Handover Notes

- draft tester comments are already posted on `#121`
- current downloadable fork asset is `codex-2.1.0-rc6`: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/codex-2.1.0-rc6>
- older `codex-2.1.0-rc1`, `codex-2.1.0-rc2`, `codex-2.1.0-rc3`, `codex-2.1.0-rc4`, and `codex-2.1.0-rc5` builds should be treated as superseded
- takeover/adoption package is documented in `docs/takeover-adoption-package.md`
- upstream issue/PR triage map is documented in `docs/upstream-triage-map.md`
- AFK batch evidence is documented in `docs/afk-batch-2026-04-24.md`
- current fork package SHA-256: `4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea`
- `codex-2.1.0-rc5` is superseded by the Divi Pixel follow-up fixes
