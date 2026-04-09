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

## Commit Lineage On This Branch

- `395b4b4` Add minimal Divi 4/5 styling compatibility layer.
- `227c133` Add slider and reduced-motion accessibility support.
- `3124b7b` Fix npm lint configuration.
- `e7a384d` Hide page content when mobile menu is open.
- `a721e9e` Add Divi 5 module accessibility settings support.

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

## Known Residual Risks

- Full Divi 4/Divi 5 runtime verification still depends on manual WordPress and builder checks.
- Search/cart control markup varies by theme/header configuration, so runtime validation should include default header and menu-module variants.
- Contact form checkbox behavior should be verified against both checkbox list and boolean checkbox field types.
