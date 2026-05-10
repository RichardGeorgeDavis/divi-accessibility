# Divi Accessibility Module Support Matrix

This matrix tracks plugin-owned accessibility fixes by module and Divi major version. It is compatibility evidence, not a WCAG conformance claim.

| Module or Area | Divi 4 Supported? | Divi 5 Supported? | Fixes Applied | Known Limitations | Manual Test Notes | Last Tested Divi Version |
| --- | --- | --- | --- | --- | --- | --- |
| Menu | Yes | Yes | Search/cart naming, mobile menu state, Escape close/focus return, submenu keyboard and ARIA support, skip-link navigation target compatibility. | Third-party menu replacements may use different markup. | Test desktop menu, mobile menu, Escape from focused menu links, search open/close, cart/account links, keyboard tab order, and `aria-expanded` state. | `2.1.8`: Divi `4.27.6`, Divi `5.3.3`; `2.1.7`: Divi `5.4.1` |
| Fullwidth Menu | Yes | Partial | Menu naming and mobile menu behavior where Divi markup matches supported selectors. | Fullwidth and custom header layouts vary by builder output. | Test desktop and mobile menu open/close, focus movement, and screen-reader isolation. | TBD |
| Search | Yes | Yes | Search field labels, open/close accessible names, keyboard activation support. | Custom search modules may need site-specific review. | Test icon buttons, visible and screen-reader labels, Enter key submission, and focus return. | `2.1.7`: Divi `4.27.6`, Divi `5.4.1`, Divi `5.3.3` |
| Contact Form | Yes | Yes | Label fixes, required/invalid state support, alert/live feedback, checkbox keyboard support. | Server-side validation messages depend on Divi output. | Submit empty/invalid/valid forms and confirm focusable fields expose labels and invalid state. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Slider | Yes | Yes | Previous/next labels, dot labels, keyboard focusability, control target sizing. | Autoplay and animation behavior depends on site settings. | Test controls with keyboard, screen reader names, and reduced-motion preference. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Tabs | Yes | Yes | Tablist/tab/tabpanel roles, selected/expanded state, keyboard arrow behavior. | Complex nested modules need manual review. | Test arrow keys, click state sync, focus visibility, and panel association IDs. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Accordion | Yes | Yes | Toggle title button semantics, keyboard activation, expanded/disabled state handling. | Timing depends on Divi open/close animation. | Test Enter/Space, open state, disabled active accordion item, and focus outline. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Toggle | Yes | Yes | Toggle title button semantics, keyboard activation, expanded state handling. | Nested interactive content needs manual review. | Test Enter/Space, mouse click parity, and screen reader state announcement. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Blog | Partial | Partial | Benefits from global link naming, focus outline, skip links, and module wrapper ARIA fields. | Post content quality, image alternatives, and excerpt links are editorial/site dependent. | Test post links, pagination, images, headings, and keyboard order. | TBD |
| WooCommerce modules | Smoke-tested | Smoke-tested | Compatibility with plugin frontend payloads, cart/account naming where Divi selectors match. | WooCommerce store-only/coming-soon responses may not print normal footer scripts. | Test shop, product, cart, checkout, account links, notices, and plugin script loading. | WooCommerce 10.7.0 with Divi 5 local smoke tests |
| Button and icon-style modules | Partial | Partial | Link/button role/name improvements where selectors match; module wrapper ARIA fields are available. | Overriding native semantics can be harmful; review custom ARIA manually. | Test accessible names, activation keys, visible focus, and native link/button behavior. | TBD |
| Image | Yes | Yes | Image helper behavior preserves explicit `alt`/`title` values and module wrapper ARIA fields are available. | Alt text quality is editorial; media-library fallback/sync remains future work. | Test generated `img` alternatives, title output, decorative-image intent, and migrated content. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Social Media Follow | Smoke-tested | Smoke-tested | Social links receive accessible names and new-window context where selectors match. | Labels depend on module configuration and should be checked for natural wording. | Test each social link's accessible name, destination, target behavior, and focus order. | `2.1.7`: Divi `4.27.6`, Divi `5.3.3` |
| Third-party modules | Smoke-tested only | Smoke-tested only | Scoped compatibility for tested integrations, especially Divi Pixel mobile menu behavior. | Third-party modules can change markup without notice. | Test module-specific keyboard behavior, names, states, and whether plugin selectors still match. | Divi Pixel 2.50.0 and 2.50.1 with Divi 5 local smoke tests |

## Notes

- Use the manual checklist in `docs/testing/manual-accessibility-checklist.md` before marking a row as tested.
- Record exact Divi, WordPress, PHP, browser, and third-party plugin versions in release notes when updating this matrix.
- Treat `Partial` as "plugin behavior can help, but the module still needs site-specific manual testing."

## 2026-05-10 `2.1.7` Runtime Evidence

- Packaged plugin under test: `packaged/divi-accessibility-2.1.7.zip`
- WordPress: `6.9.4`
- PHP: `8.5.3`
- Browser: Chrome through Playwright MCP, 1366 by 900 viewport
- Divi 4 matrix site: `blueprint`, Divi `4.27.6`
- Divi 5 packaged-plugin smoke site: `master-licenses`, Divi `5.4.1`
- Divi 5 module matrix site: `tester`, Divi `5.3.3`
- Checks that passed: package install, activation, deactivation/reactivation, option preservation/default merge, frontend `_da11y.version`, Divi body class, skip-link focus, mobile menu role/name/state, search labels/names, cart naming where present, slider labels, contact text field state, contact checkbox keyboard toggle, tab roles/associations, accordion/toggle semantics, image helper output, social-link names, and D4-style shortcode enhancement on Divi 5.
- No full WCAG conformance claim is made from this matrix.

## 2026-05-10 `2.1.8` Targeted Runtime Evidence

- Packaged plugin under test: `packaged/divi-accessibility-2.1.8.zip`
- WordPress: `6.9.4`
- PHP: `8.5.3`
- Browser: Chrome through the Codex in-app browser
- Divi 4 site: `blueprint`, Divi `4.27.6`
- Divi 5 module site: `tester`, Divi `5.3.3`
- Divi 5 packaged-plugin smoke site: `master-licenses`, Divi `5.4.1`
- Checks that passed: Escape from a focused mobile menu link closes the menu, updates `aria-expanded` to `false`, removes `.mobile_nav.opened`, returns focus to `.mobile_menu_bar`, and leaves no focused menu link on both Divi 4 and Divi 5.
- Regression checks that still passed: Divi 5 saved hide/screen-reader-only module output, D4-to-D5 migrated hide/screen-reader-only output, and default-header search/cart labels.
- Updater stale-cache check: stale cached release data without `checksum` was refreshed, and the missing-checksum warning count did not increase.
