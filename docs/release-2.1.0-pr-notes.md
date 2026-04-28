# Release 2.1.0 PR Notes

## Status

Ready for upstream review.

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
- fixed Divi 5 frontend rendering for saved module accessibility toggles by applying accessibility classes through the `render_block` path
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
  - Divi 5 Visual Builder persistence pass:
    - `Hide From Screen Readers` persisted after save/reopen and the frontend output rendered the saved hidden module state
    - `Show For Screen Readers Only` persisted after save/reopen and the frontend output rendered the saved screen-reader-only module state
  - Divi 4 packaged-plugin smoke pass:
    - skip link and keyboard focus outline passed
    - mobile menu opened/closed with keyboard Enter and restored plugin-managed `aria-hidden`
    - generated submenu smoke case updated parent `aria-expanded` on focus and Escape
    - slider arrows/dots, contact-form invalid state/live region, and toggle/accordion `aria-expanded` passed
    - legacy module-level accessibility attributes affected frontend output
  - D4-to-D5 migration compatibility pass:
    - D4-authored `hide_aria_element` and `show_for_screen_readers_only` attributes embedded in migrated Divi 5 block content rendered the expected frontend output

## Still Needs Integration Review

- maintainer closure of upstream issue `#90` after reviewing the now-landed fix in `#121`
- broader reporter validation for menu/header variants in `#122`, `#91`, `#51`, `#71`, and `#69`
- alternate search/cart Theme Builder variants beyond the already-tested local configurations

## Final Runtime Results

- `npm run lint`: pass
- `npm run package`: pass
- zip content inspection: pass
- final maintained-fork release: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
- final zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
- current package SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`
- Divi 5 Visual Builder save/reopen persistence: pass
- Divi 5 frontend output for saved module accessibility toggles: pass
- Divi 4 runtime smoke: pass
- D4-to-D5 legacy accessibility attribute frontend behavior: pass

## Handover Notes

- draft tester comments are already posted on `#121`
- these are historical `2.1.0` upstream PR notes; the current maintained-fork release is `2.1.3`
- historical final `2.1.0` asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
- historical `2.1.0` zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
- older `codex-2.1.0-rc1`, `codex-2.1.0-rc2`, `codex-2.1.0-rc3`, `codex-2.1.0-rc4`, and `codex-2.1.0-rc5` builds should be treated as superseded
- `codex-2.1.0-rc6` is superseded by the Divi 5 frontend render-block follow-up fix, and `codex-2.1.0-rc7` is superseded by final `2.1.0`
- takeover/adoption package is documented in `docs/takeover-adoption-package.md`
- upstream issue/PR triage map is documented in `docs/upstream-triage-map.md`
- AFK batch evidence is documented in `docs/afk-batch-2026-04-24.md`
- current local fork package SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`
