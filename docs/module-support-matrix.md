# Divi Accessibility Module Support Matrix

This matrix tracks plugin-owned accessibility fixes by module and Divi major version. It is compatibility evidence, not a WCAG conformance claim.

| Module or Area | Divi 4 Supported? | Divi 5 Supported? | Fixes Applied | Known Limitations | Manual Test Notes | Last Tested Divi Version |
| --- | --- | --- | --- | --- | --- | --- |
| Menu | Yes | Yes | Search/cart naming, mobile menu state, submenu keyboard and ARIA support, skip-link navigation target compatibility. | Third-party menu replacements may use different markup. | Test desktop menu, mobile menu, search open/close, cart/account links, keyboard tab order, and `aria-expanded` state. | TBD |
| Fullwidth Menu | Yes | Partial | Menu naming and mobile menu behavior where Divi markup matches supported selectors. | Fullwidth and custom header layouts vary by builder output. | Test desktop and mobile menu open/close, focus movement, and screen-reader isolation. | TBD |
| Search | Yes | Yes | Search field labels, open/close accessible names, keyboard activation support. | Custom search modules may need site-specific review. | Test icon buttons, visible and screen-reader labels, Enter key submission, and focus return. | TBD |
| Contact Form | Yes | Yes | Label fixes, required/invalid state support, alert/live feedback, checkbox keyboard support. | Server-side validation messages depend on Divi output. | Submit empty/invalid/valid forms and confirm focusable fields expose labels and invalid state. | TBD |
| Slider | Yes | Yes | Previous/next labels, dot labels, keyboard focusability, control target sizing. | Autoplay and animation behavior depends on site settings. | Test controls with keyboard, screen reader names, and reduced-motion preference. | TBD |
| Tabs | Yes | Yes | Tablist/tab/tabpanel roles, selected/expanded state, keyboard arrow behavior. | Complex nested modules need manual review. | Test arrow keys, click state sync, focus visibility, and panel association IDs. | TBD |
| Accordion | Yes | Yes | Toggle title button semantics, keyboard activation, expanded/disabled state handling. | Timing depends on Divi open/close animation. | Test Enter/Space, open state, disabled active accordion item, and focus outline. | TBD |
| Toggle | Yes | Yes | Toggle title button semantics, keyboard activation, expanded state handling. | Nested interactive content needs manual review. | Test Enter/Space, mouse click parity, and screen reader state announcement. | TBD |
| Blog | Partial | Partial | Benefits from global link naming, focus outline, skip links, and module wrapper ARIA fields. | Post content quality, image alternatives, and excerpt links are editorial/site dependent. | Test post links, pagination, images, headings, and keyboard order. | TBD |
| WooCommerce modules | Smoke-tested | Smoke-tested | Compatibility with plugin frontend payloads, cart/account naming where Divi selectors match. | WooCommerce store-only/coming-soon responses may not print normal footer scripts. | Test shop, product, cart, checkout, account links, notices, and plugin script loading. | WooCommerce 10.7.0 with Divi 5 local smoke tests |
| Button and icon-style modules | Partial | Partial | Link/button role/name improvements where selectors match; module wrapper ARIA fields are available. | Overriding native semantics can be harmful; review custom ARIA manually. | Test accessible names, activation keys, visible focus, and native link/button behavior. | TBD |
| Third-party modules | Smoke-tested only | Smoke-tested only | Scoped compatibility for tested integrations, especially Divi Pixel mobile menu behavior. | Third-party modules can change markup without notice. | Test module-specific keyboard behavior, names, states, and whether plugin selectors still match. | Divi Pixel 2.50.0 and 2.50.1 with Divi 5 local smoke tests |

## Notes

- Use the manual checklist in `docs/testing/manual-accessibility-checklist.md` before marking a row as tested.
- Record exact Divi, WordPress, PHP, browser, and third-party plugin versions in release notes when updating this matrix.
- Treat `Partial` as "plugin behavior can help, but the module still needs site-specific manual testing."
