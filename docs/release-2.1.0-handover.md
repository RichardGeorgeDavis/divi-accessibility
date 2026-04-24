# Release 2.1.0 Handover

## Scope

Release `2.1.0` is the compatibility and modernization release for Divi Accessibility. The release target is:

- make Divi 5 a first-class supported target
- preserve Divi 4 behavior and existing module-level settings
- harden the packaging, lint, metadata, and documentation paths so the release can ship as a real plugin package

## Branch Status

- Working branch: `codex/divi4-divi5-style-compat`
- Upstream base: `origin/master`
- Current release target: `2.1.0`
- Upstream PR head at final release: `2ce67b8`
- Upstream ready-for-review PR: `#121` <https://github.com/campuspress/divi-accessibility/pull/121>
- Takeover/adoption package: `docs/takeover-adoption-package.md`
- Upstream issue/PR triage map: `docs/upstream-triage-map.md`
- AFK batch evidence: `docs/afk-batch-2026-04-24.md`
- Downloadable maintained-fork release:
  - current release page: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
  - current zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
  - current zip SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`
  - previous superseded builds: `codex-2.1.0-rc1`, `codex-2.1.0-rc2`, `codex-2.1.0-rc3`, `codex-2.1.0-rc4`, `codex-2.1.0-rc5`, `codex-2.1.0-rc6`, `codex-2.1.0-rc7`

## Commit Lineage On This Branch

- `395b4b4` Add minimal Divi 4/5 styling compatibility layer.
- `227c133` Add slider and reduced-motion accessibility support.
- `3124b7b` Fix npm lint configuration.
- `e7a384d` Hide page content when mobile menu is open.
- `a721e9e` Add Divi 5 module accessibility settings support.
- `7938dc6` Prepare 2.1.0 release candidate.
- `7a59685` Write packages to packaged directory.
- `3f4cf7a` Record visual verification progress.
- `c35a85f` Document remaining verification tasks.
- `de40c78` Fix tota11y default handling.
- `75003ef` Refresh release handover docs.

## Divi 4 vs Divi 5 Notes

### Divi 4

- Keeps the legacy module field hooks for:
  - `hide_aria_element`
  - `show_for_screen_readers_only`
- Frontend behavior continues to read the legacy flat module props.

### Divi 5

- Uses a Visual Builder asset path to inject the `Accessibility Settings` group.
- Stores the same two controls in the nested D5 settings shape.
- Frontend behavior supports both the legacy flat props and the D5 nested props.
- Migrated D4 content is mapped so legacy accessibility attrs keep working after D5 conversion.

## Release-Blocking Checks

- metadata is aligned across plugin header, `DA11Y_VERSION`, `package.json`, `readme.txt`, and POT metadata
- plugin package includes `languages/`
- npm lint covers both public JS and admin-side Divi 5 builder JS
- release zip installs and activates cleanly in WordPress
- Divi 4 and Divi 5 runtime checks are both completed

## What Has Been Verified

- `npm run lint`
- `npm run build`
- `npm run i18n`
- `npm run release`
- package zip generation and zip content inspection
- packaged-plugin install, activate, deactivate, and reactivate smoke check on a local Divi 5 package-smoke site
- frontend response from the local Divi 5 package-smoke site includes Divi Accessibility payload for Divi 5
- Divi 5 browser-driven navbar/submenu follow-up for issue `#122`:
  - parent menu focus opens the submenu and sets `aria-expanded="true"`
  - Escape closes the submenu and restores `aria-expanded="false"`
  - mobile menu screen-reader isolation still opens and restores correctly
- Divi 5 browser-driven module page follow-up on a local Divi 5 module test page:
  - slider controls and dots expose keyboard roles, labels, and active-dot state
  - contact-form invalid submit syncs `aria-required`, `aria-invalid`, and live-region state
  - toggle/accordion controls expose button semantics and matching expanded state
  - tabs keyboard navigation keeps panel `aria-hidden` synchronized after the scoped selector fix
- Divi Pixel alternate mobile-header follow-up on local Divi Pixel test site A:
  - `divi-accessibility` `2.1.0` and `divi-pixel` `2.50.0` are active
  - Divi Pixel hamburger opens and closes without Divi Accessibility console errors
  - opened menu sets `aria-expanded="true"` and hides `#main-content` and `#et-main-area` from screen readers
  - closed menu removes plugin-managed `aria-hidden` and restores the closed hamburger state
- Second local Divi 5 / Divi Pixel / WooCommerce runtime sweep:
  - active target plugins are `divi-accessibility` `2.1.0`, `divi-pixel` `2.50.1`, and `woocommerce` `10.7.0`
  - `divimenus`, `divimenus-on-media`, `divimenus-sharing`, and `dondivi-builder` are installed but inactive
  - `advanced-toggle-module-for-divi`, `divi-assistant`, and `divi-modules-table-maker` are not installed
  - all 17 published pages returned HTTP `200`
  - 14 normal Divi pages loaded `_da11y.version` `2.1.0`, skip link, `role="main"`, and labelled mobile menu controls
  - Cart, Checkout, and Shop render WooCommerce store-only/coming-soon output that does not print the normal footer scripts, so no footer-enqueued plugin JS runs there
  - homepage Divi Pixel mobile-menu open/close passed after adding class-change observation for third-party menu state changes
- ownership/release metadata cleanup:
  - license metadata normalized to `GPL-2.0-or-later`
  - README/readme preserve CampusPress creator credit and state Richard George Davis as current fork maintainer
  - fork GitHub links are primary for fork releases
  - upstream issue/PR triage map added
  - rebuilt package installs and remains active on the local Divi 5 package-smoke site
- targeted `php -l` and `node --check`
- manual visual pass:
  - frontend tabs working
  - Divi 5 Visual Builder modules show `Accessibility Settings`

## Upstream Cleanup Already Done

- superseded draft PRs closed:
  - `#119`
  - `#118`
  - `#117`
  - `#116`
  - `#110`
  - `#109`
  - `#97`
- related issues updated to point at `#121`
- issues closed as already resolved by `#121`:
  - `#120`
  - `#115`
  - `#113`
  - `#101`
  - `#100`
- issue `#90` is fixed in code and linked to `#121`, but could not be closed directly due upstream permissions
- maintainer follow-up posted on `#121` on 2026-04-16 with review, merge, and issue-closure asks
- RC2 verification progress posted on `#121` on 2026-04-24:
  - <https://github.com/campuspress/divi-accessibility/pull/121#issuecomment-4311364696>
- upstream issue `#122` opened on 2026-04-14; one related Divi 5 submenu state bug was reproduced and fixed in the refreshed branch/package
- upstream issue/PR triage map added at `docs/upstream-triage-map.md`

## Next Steps

1. Use final `2.1.0` as the maintained-fork release asset.
2. Keep upstream PR `#121` as the canonical CampusPress merge path.
3. Ask maintainers to close issues `#90`, `#96`, and `#88` after reviewing/merging `#121`.
4. Keep broader validation issues open until reporters or maintainers confirm their original cases.
5. Keep older open PRs as follow-up work unless maintainers explicitly ask to fold any into `#121`.
6. If there is still no upstream response, use `docs/takeover-adoption-package.md` to contact CampusPress and prepare the WordPress.org adoption request.

## Known Residual Risks

- Search/cart control markup varies by theme/header configuration, so runtime validation should still include default header and menu-module variants.
- WooCommerce store-only/coming-soon Cart, Checkout, and Shop output on the local WooCommerce test site does not print the normal footer scripts; this prevents any footer-enqueued plugin JS from running on those responses.
- Contact form checkbox behavior should be verified against both checkbox list and boolean checkbox field types.
- All `codex-2.1.0-rc*` assets are superseded by final `2.1.0`.
- WordPress.org lists `accessible-divi` as permanently closed by author request, so official adoption may require CampusPress approval or may be denied by the Plugin Review Team.
