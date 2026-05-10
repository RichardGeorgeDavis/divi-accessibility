# GitHub Issue Closeout Comments

Prepared: 2026-05-10

Use these comments after the `2.1.8` release asset and CI verification recorded
in `docs/afk-batch-2026-05-10.md`.

## Current 2.1.8 Draft Notes

### Issue #73

```text
Follow-up from the 2.1.8 runtime pass:

I reproduced this against the packaged 2.1.7 plugin on local Divi 4 and Divi 5 sites. When focus was on a mobile menu link and Escape was pressed, the menu stayed open (`aria-expanded="true"` / `.mobile_nav.opened`) and focus stayed on the menu link.

The 2.1.8 fix closes the open mobile menu from that path, sets the menu button back to `aria-expanded="false"`, removes the open menu class, returns focus to `.mobile_menu_bar`, and leaves no focused menu link.

Validated locally on:
- WordPress 6.9.4 / PHP 8.5.3 / Divi 4.27.6
- WordPress 6.9.4 / PHP 8.5.3 / Divi 5.3.3

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.8
Zip SHA-256: 5db50373276be3f67181357420a6c811616a8cac62785cd7e01c028a343f3ea9
```

### Issue #72

```text
Related 2.1.8 validation:

Escape from a focused mobile menu link now closes the mobile menu and restores focus to the menu button on local Divi 4 and Divi 5 sites. That covers the shared "focus remains inside a closed/opening mobile menu path" failure mode.

I would keep this issue open until the original submenu-specific reverse-tab path is retested, because that report may involve a different submenu/focus sequence.
```

### Issue #88

```text
Additional 2.1.8 validation:

I added a Divi 5 saved-attribute fixture and confirmed frontend output for both module accessibility toggles:
- saved `hideAriaElement` output receives `aria-hidden` plus `aria-hidden="true"`
- saved `showForScreenReadersOnly` output receives `screen-reader-text` and does not receive `aria-hidden="true"`

D4-to-D5 migrated hide/screen-reader-only output also passed on the Divi 5 migration page. If maintainers require UI-level proof, the remaining validation is a live Visual Builder save/reopen pass on the reporter's Divi version.
```

### Issue #69

```text
Additional 2.1.8 validation:

The default Divi 5 header path on the local `master-licenses` site exposes the expected names:
- search icon: "Open search"
- close search: "Close search"
- cart: "View cart"
- header search form: "Search form"

I would keep this open for reporter validation because the original report is specifically about Theme Builder header output, and alternate Theme Builder/menu-module markup can differ from the default header path.
```

---

Prepared: 2026-04-24

Use these comments for final `2.1.0` upstream issue closeout.

Final maintained-fork release:

- Release: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
- Zip: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
- SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`

## Fixed / Request Maintainer Closure

### Issue #90

Action: comment and close if permission allows; otherwise ask maintainers to close.

```text
Final 2.1.0 follow-up:

This is fixed by #121 and included in the final maintained-fork 2.1.0 release. The `tota11y` setting is now initialized/cast before use, so the undefined-variable path reported here is addressed.

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef

Maintainers: please close this as fixed by #121 after review.
```

### Issue #96

Action: comment and close if permission allows; otherwise ask maintainers to close.

```text
Final 2.1.0 follow-up:

Divi 5 support is implemented in #121 and included in the final maintained-fork 2.1.0 release. Final runtime gates passed for Divi 5 Visual Builder setting visibility, save/reopen persistence for both module-level accessibility toggles, frontend output for saved toggles, and D4-to-D5 legacy accessibility attribute behavior.

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef

Maintainers: please close this as fixed by #121 after review.
```

### Issue #88

Action: comment and close if permission allows; otherwise ask maintainers to close.

```text
Final 2.1.0 follow-up:

This is fixed by #121 and included in the final maintained-fork 2.1.0 release. The module accessibility toggles were verified in Divi 5 Visual Builder after save/reopen, and frontend output was verified for both saved `Hide From Screen Readers` and `Show For Screen Readers Only` states. Legacy D4-authored `hide_aria_element` and `show_for_screen_readers_only` attributes were also verified in migrated Divi 5 block content.

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef

Maintainers: please close this as fixed by #121 after review.
```

## Validation Comments, Do Not Close Yet

### Issue #122

```text
Follow-up from the latest 2.1.0 runtime pass:

The final maintained-fork 2.1.0 package includes additional navbar/mobile-menu fixes after the earlier RC notes:
- submenu focus state keeps visible submenu state and aria-expanded in sync
- Divi Pixel mobile headers now sync aria-expanded from the actual menu state
- mobile menu screen-reader isolation is restored on close
- #et-main-area fallback support was added for templates that do not include #main-content

Runtime-tested active plugin context:
- Divi Pixel 2.50.0 on one local Divi 5 test site
- Divi Pixel 2.50.1 and WooCommerce 10.7.0 on a second local Divi 5 test site

Known limit from testing: WooCommerce store-only/coming-soon responses that do not print normal footer scripts cannot run footer-enqueued Divi Accessibility JavaScript on those responses.

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef

I am keeping this open because the reporter's exact site/header setup may differ. Useful validation would be Divi version, header/menu implementation, active menu-related plugins, and whether submenu visibility plus screen-reader announcement behavior is fixed.
```

### Issue #91

```text
This should be covered by the final 2.1.0 work in #121, but I would like reporter/maintainer validation before closing.

The final package now:
- syncs submenu visibility and aria-expanded for keyboard-opened submenus
- syncs mobile menu aria-expanded from the actual open menu state
- observes third-party menu class changes so alternate/mobile headers such as Divi Pixel do not leave stale aria-expanded values
- restores plugin-managed aria-hidden state when the mobile menu closes

Verified against Divi Pixel 2.50.0 and 2.50.1 mobile-header setups.

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef
```

### Issue #51

```text
This may be fixed by the final 2.1.0 mobile-menu rewrite in #121, but it needs validation against the original header/setup before closing.

The final package improves mobile menu keyboard handling by:
- applying button semantics and tabindex to Divi and Divi Pixel menu controls
- supporting Enter/Space activation on delegated mobile controls
- syncing from the actual open menu state instead of toggling an internal flag
- observing third-party class changes when alternate headers update state outside the normal click path

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef
```

### Issue #71

```text
This may be fixed by the final 2.1.0 mobile-menu state rewrite in #121, but it needs reporter-style validation before closing.

The final package no longer relies on an internal "opened" flag that can drift from Divi/third-party menu state. It now syncs aria-expanded and content isolation from the actual open classes, and observes menu class changes made by alternate headers such as Divi Pixel.

Verified open/close behavior with:
- Divi Pixel 2.50.0 on one local Divi 5 test site
- Divi Pixel 2.50.1 on a second local Divi 5 test site

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef
```

### Issue #69

```text
Partial follow-up from the final 2.1.0 work in #121:

The final package improves accessible names for default header and menu search/cart controls, and this has been included in browser runtime checks. However, I would keep this issue open until more Theme Builder/menu-module variants are tested because the original report is specifically about custom Theme Builder header output.

Release: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0
Zip SHA-256: 69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef
```
