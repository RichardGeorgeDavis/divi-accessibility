# Upstream Issue And PR Triage Map

Status checked: 2026-05-10

## Strategy

- Do not clone all upstream issues into the fork.
- Treat upstream PR `#121` as historical takeover-compatible context for the `2.1.0` release; it was closed by the 2026-05-10 status check.
- Use this map to decide what is fixed, what needs reporter validation, what stays backlog, and what should not be folded into `2.1.0`.
- Leave upstream issues open unless maintainer permissions are granted.

## Runtime-Tested Plugin Evidence

The third-party plugin list is evidence for compatibility triage only. Do not describe inactive or absent plugins as tested.

| Plugin | Tested status | Evidence / issue impact |
| --- | --- | --- |
| Divi Pixel `2.50.0` | Active on local Divi Pixel test site A | Mobile/header hamburger open and close now sync `aria-expanded` and screen-reader isolation. Supports issue `#91`, possibly `#51` and `#71`. |
| Divi Pixel `2.50.1` | Active on local Divi Pixel test site B | 17-page sweep completed; homepage Divi Pixel menu passes after class-change observer. Supports issue `#91`, possibly `#51` and `#71`. |
| WooCommerce `10.7.0` | Active on local Divi Pixel test site B | Account-like pages that print footer scripts load `_da11y` normally. Cart, Checkout, and Shop currently render WooCommerce store-only/coming-soon output without normal footer scripts, so footer-enqueued plugin JS cannot run there. This is a known remaining template/site limitation, not a `2.1.0` JS regression. |
| DiviMenus, DiviMenus On Media, DiviMenus Sharing, DonDivi Builder | Installed but inactive on local Divi Pixel test site B | Do not claim tested. Keep menu/mega-menu reports such as `#53`, `#56`, and `#31` open until active runtime pages exist. |
| Advanced Toggle Module for Divi, Divi Assistant, Divi Modules Table Maker | Not installed on the checked sites | Do not claim tested. Add to follow-up compatibility backlog only if a page/site is provided. |

## Final 2.1.0 Issue Closeout Queue

These are the safest immediate issue actions after the latest runtime checks:

| Item | Recommended action | Rationale |
| --- | --- | --- |
| `#112` Slider labels/keyboard parity | Already commented and closed with release evidence. | The scoped acceptance criteria are implemented and verified on the Divi 5 module test page. |
| `#114` Contact form announcements | Already commented and closed with release evidence. | Invalid submit now syncs `aria-required`, `aria-invalid`, and live-region state in runtime verification. |
| `#107` Stale upstream branches/PR cleanup | Comment with the current PR disposition and close as tracking complete. | The remaining stale PRs are now explicitly classified in this map; further action is maintainer/admin cleanup rather than a release blocker. |

These should not be closed yet, but should get focused validation comments:

| Item | Recommended action | Rationale |
| --- | --- | --- |
| `#122` New navbar report | Comment with the final release hash and plugin-tested context; ask reporter to validate on their actual header/site. | We fixed and verified related submenu/mobile-header behavior, but the reporter's exact site/header remains unknown. |
| `#91` Mobile submenu expanded state | Comment as probably fixed by the mobile menu observer and submenu state work; ask for validation. | Divi Pixel mobile headers pass, but the original report does not identify the exact header implementation. |
| `#51` Burger menu does not expand | Comment as possibly fixed by the keyboard/mobile-menu rewrite; ask for validation. | Enter/Space handling is improved, but the original WP 5.7.2/Divi 4-era case needs a direct retest. |
| `#71` Two clicks to close mobile menu | Comment as possibly fixed by syncing from real menu state; ask for validation. | The open/close stale-state class problem is addressed, but the original site-specific reproduction involved clicks inside the menu/header. |
| `#69` Theme Builder menu search naming | Comment with current search/cart naming coverage and keep open. | Search/cart labels are improved, but alternate Theme Builder/menu-module variants still need broader runtime coverage. |

Do not close yet:

- `#96`: closure candidate now that Divi 5 Visual Builder persistence, Divi 4 smoke, and D4-to-D5 migration checks are complete.
- `#88`: closure candidate now that Visual Builder save/reopen persistence and frontend output for both module accessibility toggles are verified.
- `#60`: contact checkbox keyboard support is improved, but close only after direct checkbox-list/boolean checkbox validation or reporter confirmation.
- `#7`: toggle/accordion semantics are improved, but the original request asks for screen-reader state-change notification; keep until manual AT behavior is explicitly validated.
- `#72`, `#73`, `#31`, `#53`, `#56`: keep open until focus-return, reverse-tab, mega-menu, and hidden-submenu-focus paths are retested against active pages.

## Fixed In 2.1.0 / Closure Candidates

These items are addressed directly or substantially by `#121` and should be closure candidates after maintainer review or reporter validation:

| Item | Reason |
| --- | --- |
| `#96` Divi 5? | `2.1.0` adds Divi 5 compatibility while preserving Divi 4 paths. |
| `#90` Undefined `$tota11y` warning | Branch initializes and casts the setting before use. |
| `#88` Hide from Screen Readers toggle not working | Branch preserves legacy attrs and adds Divi 5 builder/frontend support. |
| `#112` Slider labels/keyboard parity | Branch adds slider labels, keyboard activation, and dot state support. |
| `#114` Contact form announcements | Branch adds invalid-state syncing and live-region support. |
| `#60` Contact form checkbox keyboard support | Branch adds keyboard support for Divi contact checkbox labels. |
| `#91` Mobile submenu `aria-expanded` mismatch | Branch fixes submenu focus/expanded state and mobile-menu isolation. |
| `#69` Theme builder menu search naming | Branch improves search/cart accessible names; alternate header configs still need final runtime coverage. |
| `#7` Accordion state changes | Branch exposes button semantics and expanded state on accordion/toggle titles. |

## Possibly Fixed / Needs Reporter Validation

These reports are in areas touched by `#121`, but the original site/header/plugin configuration may differ:

| Item | Validation needed |
| --- | --- |
| `#122` DIVI accessibility plugin does not work | RC4 fixes one related submenu state bug; reporter should validate against the affected site. |
| `#73` ESC focus behavior | Mobile-menu close behavior was improved, but focus-return expectations need a specific mobile-header retest. |
| `#72` Focus after closing submenu | Submenu Escape and focus behavior changed; needs regression testing against the original case. |
| `#71` Takes two clicks to close mobile menu | Mobile-menu open/close state was reworked; needs reporter-style retest. |
| `#56` Tab through menu not working | Navbar/submenu keyboard behavior changed; needs full keyboard-path validation. |
| `#53` Mega Menu closes on second column first sub-item | Mega-menu-specific markup was not part of the final runtime page. |
| `#31` Shift+Tab through main navigation | Related to submenu focus handling, but requires reverse-tab runtime validation. |
| `#85` Aria labels not generated | Several labels are improved, but this report is too broad to close without exact markup. |
| `#76` Duplicate focus tabs | Runtime testing did not specifically reproduce this report. |
| `#21` Fix labels issue | Label handling is improved, but the old report needs exact-case validation. |

## Backlog / Not Blocking 2.1.0

These are valid follow-up candidates but should not block the compatibility release:

| Item | Disposition |
| --- | --- |
| `#104` Settings screen UI refresh | Defer; broad UI/information-architecture work. |
| `#103` Frontend script conditional loading | Defer; performance hardening after release. |
| `#102` WCAG 2.2 roadmap review | Defer; planning item, not a release blocker. |
| `#94` Toggle role audit | Partially covered by toggle semantics; keep for axe/manual follow-up. |
| `#81` Social media links ADA issues | Needs isolated social-module testing. |
| `#78` Update gone wrong 2.0.1 to 2.0.5 | Historical support issue; not actionable without reproduction. |
| `#75` Wrap body content with `<main>` | Current branch assigns `role="main"`; structural wrapper change is broader. |
| `#74` Console output debugging | Defer developer-mode/debug-output work. |
| `#59` Localization | Defer translation workflow improvements beyond packaging POT. |
| `#58` Visual Builder loading after Divi 4.12 | Historical compatibility issue; final VB persistence testing remains separate. |
| `#57` Install support | Documentation/support item. |
| `#52` Remove redundant `role="link"` | Potential cleanup but can affect established behavior; not for `2.1.0`. |
| `#51` Burger menu does not expand | Needs original-header reproduction. |
| `#50` Gravity Forms issue | Third-party plugin compatibility; out of scope for `2.1.0`. |
| `#25` iframe focusin error | Needs isolated iframe test case. |
| `#23` Duplicate menu appearing | Historical WordPress 5.2 report. |
| `#19` Customizable aria labels | Enhancement; keep for later settings work. |

## Open PR Disposition

| PR | Disposition |
| --- | --- |
| `#121` | Canonical upstream merge PR for final `2.1.0`. |
| `#111` | Do not fold; developer-mode debug output is backlog. |
| `#108` | Do not fold until mega-menu/reverse-tab cases are retested. |
| `#106` | Do not fold separately; evaluate after final mobile-menu focus-return testing. |
| `#105` | Do not fold into `2.1.0`; redundant link role cleanup is behavior-changing. |
| `#98` | Superseded or partially covered by `#121`; validate before closure. |
| `#99` | Superseded or partially covered by `#121`; validate before closure. |
| `#84` | Superseded by `2.1.0` metadata. |
| `#70`, `#68`, `#63`, `#62`, `#61`, `#55` | Stale dependency bumps; regenerate dependencies separately after release. |
| `#66` | Superseded by the current Divi 4/5 module accessibility settings implementation. |
| `#54` | Do not fold separately; search naming is improved in `#121`, but role/search semantics need alternate-header validation. |

## Next Triage Actions

- Link this map from release handover and adoption package.
- Ask maintainers to use this map when deciding which old issues/PRs are superseded by `#121`.
- After final runtime gates pass, post a concise upstream summary listing closure candidates rather than commenting on every old issue.
