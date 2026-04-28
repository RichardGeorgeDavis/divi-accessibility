# Manual Accessibility Checklist

Use this checklist for release smoke tests and module support updates. These checks verify WCAG-aligned improvements in this plugin; they do not certify whole-site WCAG conformance.

## Environment

- WordPress version:
- PHP version:
- Divi version:
- Divi mode: Divi 4 / Divi 5 Visual Builder / Divi 5 frontend
- Browser and assistive technology:
- Active third-party plugins:
- Test page URL:

## Keyboard And Focus

- Navigate the page with keyboard only.
- Confirm focus is always visible on links, buttons, fields, menus, sliders, tabs, accordions, toggles, and skip links.
- Confirm tab order follows the visual/content order and does not enter hidden mobile menus, hidden tabs, or closed accordion panels unexpectedly.
- Confirm Enter and Space activate custom button-like controls where expected.

## Skip Links

- With default settings, first Tab reveals only "Skip to content".
- With navigation/content/footer enabled, links appear in navigation, content, footer order.
- Enter on each skip link moves focus to the first matching configured target.
- Missing navigation or footer targets do not render dead skip links.
- Skip links remain visually hidden until focused when the separate screen-reader-text option is disabled.

## Menu And Mobile Menu

- Test desktop menu keyboard navigation and submenu behavior.
- Confirm mobile menu open/close control has a useful accessible name.
- Confirm `aria-expanded` changes when the mobile menu opens and closes.
- Confirm background content is isolated from screen readers while the mobile menu is open when the plugin option is enabled.
- Repeat with known third-party menu integrations such as Divi Pixel when relevant.

## Search, Cart, And Account Controls

- Confirm search open and close controls have accessible names.
- Confirm search inputs have labels.
- Confirm cart/account icon links have useful accessible names.
- Confirm custom icon controls are keyboard focusable only when they behave as controls.

## Slider

- Confirm previous and next controls are keyboard reachable and named.
- Confirm dot controls expose slide-specific labels.
- Confirm current/changed slide state is understandable.
- Confirm reduced-motion preference prevents or limits motion where the plugin supports it.

## Contact Forms

- Confirm all visible fields have labels.
- Confirm required fields expose required state.
- Submit invalid data and confirm invalid fields expose `aria-invalid`.
- Confirm success/error feedback is announced by assistive technology.
- Confirm checkbox fields can be toggled with keyboard.

## Tabs, Accordions, And Toggles

- Confirm tabs expose tablist/tab/tabpanel relationships.
- Confirm arrow keys move between tabs and update selected state.
- Confirm hidden tab panels are not announced as active content.
- Confirm accordion/toggle headings can be activated with Enter and Space.
- Confirm expanded/collapsed state updates after mouse and keyboard activation.

## Module ARIA Fields

- Confirm valid plugin-owned module ARIA fields render on the module wrapper.
- Confirm invalid role values do not render.
- Confirm ID reference fields strip invalid characters and do not render when empty after sanitization.
- Confirm existing `hide_aria_element` and `show_for_screen_readers_only` behavior still works.
- Avoid using `aria-label` and `aria-labelledby` together unless the result has been tested.
- Do not hide modules that contain focusable/interactable content from screen readers.
- Do not add positive `tabindex`; generic tabindex controls are intentionally deferred.

## Divi 4 And Divi 5

- Divi 4: confirm legacy shortcode/module output still receives plugin classes and attributes.
- Divi 5 Visual Builder: confirm plugin-owned builder controls load only when Divi 5 Visual Builder is active.
- Divi 5 frontend: confirm migrated Divi 4 plugin attributes render from the compatibility namespace.
- Confirm Divi 5 native Advanced > Attributes still works independently.
- Confirm no duplicate attributes are emitted when native Divi attributes and plugin legacy values target the same wrapper.

## WooCommerce And Third-Party Smoke Tests

- WooCommerce: test shop, product, cart, checkout, account links, notices, and frontend script loading.
- Confirm store-only/coming-soon responses are noted when they do not print normal footer scripts.
- Divi Pixel/mobile-menu integrations: test hamburger controls, menu state, focus order, and screen-reader isolation.

## Documentation Notes

- Record failures with page URL, module, Divi version, browser, and reproduction steps.
- Update `docs/module-support-matrix.md` only after completing the relevant checks.
