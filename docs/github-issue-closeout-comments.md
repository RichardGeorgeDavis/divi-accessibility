# GitHub Issue Closeout Comments

Prepared: 2026-04-24

Use these comments after publishing the current package as `codex-2.1.0-rc6` or final `2.1.0`.

Current local package:

- `packaged/divi-accessibility-2.1.0.zip`
- SHA-256: `4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea`

## Close Now

### Issue #112

Action: comment and close.

```text
Closing this as addressed by the 2.1.0 release-candidate work in #121.

Verified in the current local package:
- slider arrows expose keyboard-operable controls with meaningful labels
- slider dots expose button semantics, "Go to slide N" labels, and active-dot state
- Space/Enter activation works for the slider controls tested on the Divi 5 module page

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea
```

### Issue #114

Action: comment and close.

```text
Closing this as addressed by the 2.1.0 release-candidate work in #121.

Verified in the current local package:
- contact-form invalid submit syncs aria-required and aria-invalid state
- contact-form feedback uses live-region semantics for assistive-technology announcement
- async rerender behavior keeps the validation state in sync after Divi updates the form markup

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea
```

### Issue #107

Action: comment and close.

```text
Closing this tracking issue as complete from the release-prep side.

The remaining upstream PR/issue disposition is now documented in the 2.1.0 triage map:
- #121 remains the canonical release-candidate PR
- stale/dependency PRs are listed separately from 2.1.0 release blockers
- older issue closure candidates and validation-needed reports are mapped for maintainer review

Remaining cleanup that requires repository maintainer/admin access can continue from that triage map rather than this issue.
```

## Validation Comments, Do Not Close Yet

### Issue #122

```text
Follow-up from the latest 2.1.0 runtime pass:

The current package includes additional navbar/mobile-menu fixes after the earlier RC3 note:
- submenu focus state keeps visible submenu state and aria-expanded in sync
- Divi Pixel mobile headers now sync aria-expanded from the actual menu state
- mobile menu screen-reader isolation is restored on close
- #et-main-area fallback support was added for templates that do not include #main-content

Runtime-tested active plugin context:
- Divi Pixel 2.50.0 on one local Divi 5 test site
- Divi Pixel 2.50.1 and WooCommerce 10.7.0 on a second local Divi 5 test site

Known limit from testing: WooCommerce store-only/coming-soon responses that do not print normal footer scripts cannot run footer-enqueued Divi Accessibility JavaScript on those responses.

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea

I am keeping this open because the reporter's exact site/header setup may differ. Useful validation would be Divi version, header/menu implementation, active menu-related plugins, and whether submenu visibility plus screen-reader announcement behavior is fixed.
```

### Issue #91

```text
This should be covered by the current 2.1.0 release-candidate work in #121, but I would like reporter/maintainer validation before closing.

The current package now:
- syncs submenu visibility and aria-expanded for keyboard-opened submenus
- syncs mobile menu aria-expanded from the actual open menu state
- observes third-party menu class changes so alternate/mobile headers such as Divi Pixel do not leave stale aria-expanded values
- restores plugin-managed aria-hidden state when the mobile menu closes

Verified against Divi Pixel 2.50.0 and 2.50.1 mobile-header setups.

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea
```

### Issue #51

```text
This may be fixed by the current 2.1.0 mobile-menu rewrite in #121, but it needs validation against the original header/setup before closing.

The current package improves mobile menu keyboard handling by:
- applying button semantics and tabindex to Divi and Divi Pixel menu controls
- supporting Enter/Space activation on delegated mobile controls
- syncing from the actual open menu state instead of toggling an internal flag
- observing third-party class changes when alternate headers update state outside the normal click path

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea
```

### Issue #71

```text
This may be fixed by the current 2.1.0 mobile-menu state rewrite in #121, but it needs reporter-style validation before closing.

The current package no longer relies on an internal "opened" flag that can drift from Divi/third-party menu state. It now syncs aria-expanded and content isolation from the actual open classes, and observes menu class changes made by alternate headers such as Divi Pixel.

Verified open/close behavior with:
- Divi Pixel 2.50.0 on one local Divi 5 test site
- Divi Pixel 2.50.1 on a second local Divi 5 test site

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea
```

### Issue #69

```text
Partial follow-up from the 2.1.0 release-candidate work in #121:

The current package improves accessible names for default header and menu search/cart controls, and this has been included in browser runtime checks. However, I would keep this issue open until more Theme Builder/menu-module variants are tested because the original report is specifically about custom Theme Builder header output.

Current package SHA-256: 4506b9ce5ea62a8f43543e78c36a02fa30ee5451e4cc970076dde3cc26866dea
```
