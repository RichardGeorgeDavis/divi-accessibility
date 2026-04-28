# Release 2.1.0 Checklist

## Current Verification Status

- Manual visual pass completed:
  - frontend tabs are working
  - Divi 5 Visual Builder modules show `Accessibility Settings`
- Packaged-plugin smoke completed on a local Divi 5 package-smoke site:
  - WordPress `6.9.4`
  - Divi `5.3.3`
  - install, activate, deactivate, and reactivate passed
  - frontend rendered plugin payload with `da11y-divi-5`, `_da11y.version` `2.1.0`, skip-link, slider, submenu, and mobile-menu scripts/styles
- Additional code-level follow-up completed:
  - issue `#90` (`tota11y` undefined-variable path) fixed in branch head `de40c78`
  - Divi 5 frontend rendering now applies saved module accessibility classes through the `render_block` path as well as the legacy Divi 4 module hook
- Divi 5 navbar/submenu runtime follow-up completed against issue `#122`:
  - focusing a parent menu item now keeps the submenu visible and sets `aria-expanded="true"`
  - Escape restores `aria-expanded="false"` and hides the submenu
  - mobile-menu screen-reader isolation still opens and restores correctly
- Divi 5 module runtime follow-up completed on a local Divi 5 module test page:
  - slider controls and dots expose keyboard roles, labels, and active-dot state
  - contact-form invalid submit syncs required/invalid/live-region state
  - toggle/accordion controls expose button semantics and matching expanded state
  - tabs keyboard navigation now keeps selected tab state and panel `aria-hidden` state synchronized
- Divi Pixel alternate mobile-header follow-up completed on local Divi Pixel test site A:
  - active plugins include `divi-accessibility` `2.1.0` and `divi-pixel` `2.50.0`
  - Divi Pixel hamburger opens with no Divi Accessibility console errors
  - opened mobile menu sets `aria-expanded="true"` on the menu controls
  - opened mobile menu sets plugin-managed `aria-hidden="true"` on `#main-content` and `#et-main-area`
  - closing the menu removes the plugin-managed `aria-hidden` attribute and restores `.mobile_nav.closed`
- Second local Divi 5 / Divi Pixel / WooCommerce runtime sweep completed:
  - active target plugins are `divi-accessibility` `2.1.0`, `divi-pixel` `2.50.1`, and `woocommerce` `10.7.0`
  - `divimenus`, `divimenus-on-media`, `divimenus-sharing`, and `dondivi-builder` are installed but inactive
  - `advanced-toggle-module-for-divi`, `divi-assistant`, and `divi-modules-table-maker` are not installed on this site
  - all 17 published pages returned HTTP `200`
  - 14 normal Divi pages loaded `_da11y.version` `2.1.0`, skip link, `role="main"`, and labelled mobile menu controls
  - Cart, Checkout, and Shop render WooCommerce store-only/coming-soon output that does not print the normal footer scripts, so no footer-enqueued plugin JS runs on those responses
  - Divi Pixel mobile-menu open/close passed on the homepage after adding class-change observation for third-party menu state changes
- Ownership and release metadata cleanup completed:
  - license metadata normalized to `GPL-2.0-or-later`
  - README/readme now preserve CampusPress credit and state current fork maintenance
  - fork GitHub links are primary for fork releases while upstream PR `#121` remains canonical for maintainer review
  - upstream issue/PR triage map added at `docs/upstream-triage-map.md`
- Final release-gate runtime pass completed:
  - Divi 5 Visual Builder persistence passed after save/reopen for `Hide From Screen Readers` and `Show For Screen Readers Only`
  - Divi 5 frontend output applies saved accessibility classes after the Visual Builder save
  - Divi 4 smoke page passed skip-link, keyboard focus outline, mobile-menu keyboard open/close, submenu expanded-state, slider, contact-form, toggle/accordion, and module accessibility-attribute checks
  - D4-authored legacy module attributes embedded in migrated Divi 5 block content apply the expected frontend output
  - local duplicate-provider conflict noted on one Divi 4 test site; the packaged plugin passed after disabling the duplicate embedded copy for the smoke test

## Remaining Tasks To Perform

- verify search/cart controls on alternate header/menu configurations; Divi Pixel mobile-menu isolation has passed on two local Divi Pixel test sites
- final maintained-fork release published as `2.1.0`
- post final upstream PR `#121` release summary after final `2.1.0` publication
- upstream PR `#121` is ready for review and remains the canonical CampusPress merge path
- ask maintainers to close upstream issues `#90`, `#96`, and `#88` after reviewing the fixes linked from `#121`

## Static Checks

- `npm run lint`
- `npm run build`
- `npm run i18n`
- `php -l` on touched PHP files
- release/package dry run
- zip content inspection

## Package Checks

- build `packaged/divi-accessibility-2.1.0.zip`
- for future GitHub-updated releases, attach the packaged zip to the stable GitHub Release with the exact asset name `divi-accessibility-X.X.X.zip`
- current package SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`
- final release page: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
- zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
- confirm zip contains:
  - `admin/`
  - `includes/`
  - `languages/`
  - `public/`
  - `divi-accessibility.php`
  - `readme.txt`
  - `uninstall.php`
- install the zip into a WordPress test site
- activate and deactivate without fatals
- confirm frontend response includes the Divi Accessibility payload
- confirm admin settings page loads

## Divi 4 Runtime Matrix

- skip link appears, targets `#main-content`, and receives keyboard focus: pass
- focus outline appears for keyboard navigation: pass
- mobile menu opens and closes with keyboard Enter and restores plugin-managed `aria-hidden`: pass
- mobile menu hides page content from screen readers while open: pass
- navbar submenu parent state updates `aria-expanded` on focus and Escape: pass on the generated submenu smoke case
- slider arrows and dots have labels, button roles, keyboard focus, and active-dot state: pass
- contact form invalid submit sets required/invalid field state and announces the error in an assertive live region: pass
- accordion/toggle controls expose button semantics and sync `aria-expanded` after keyboard interaction: pass
- legacy module-level accessibility attributes still affect frontend output: pass

## Divi 5 Runtime Matrix

- frontend checks above still pass
- Visual Builder shows `Accessibility Settings`: pass
- both toggles persist after save and reopen: pass
- saved `Hide From Screen Readers` renders an `.aria-hidden` module and receives `aria-hidden="true"` from the existing runtime script: pass
- saved `Show For Screen Readers Only` renders a `.screen-reader-text` module: pass
- D4-authored legacy attrs in migrated Divi 5 block content preserve frontend behavior:
  - `hide_aria_element`: pass
  - `show_for_screen_readers_only`: pass
- navbar/submenu behavior is checked against the issue `#122` complaint pattern: pass on the Divi 5 homepage after the focus/`aria-expanded` fix
- tabs keyboard navigation keeps tab controls and panels synchronized: pass on the Divi draft module page after the scoped panel-reset fix

## Reviewer Notes

- verify the package, not just the source checkout
- test with developer mode off and on
- include at least one page with menu search/cart, slider, and contact form modules
- upstream PR context: `#121`
- takeover/adoption package: `docs/takeover-adoption-package.md`
- upstream issue/PR triage map: `docs/upstream-triage-map.md`
- AFK batch evidence: `docs/afk-batch-2026-04-24.md`
