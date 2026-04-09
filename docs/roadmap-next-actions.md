# Roadmap / Next Actions

## Current status

- Completed in this repo:
  - Slider accessibility labels and keyboard support.
  - Reduced motion support.
  - Contact form live-region and `aria-invalid` improvements.
  - Minimal Divi 4/5 compatibility hooks.
  - NPM lint configuration now passes with ESLint 9 + CSS syntax checks.
  - Mobile menu now hides main page content from screen readers while open.
  - Divi 5 builder integration now registers the two module-level accessibility toggles and maps legacy D4 attrs into the D5 settings structure.
- Commits:
  - `227c133` `Add slider and reduced-motion accessibility support`
  - `3124b7b` `Fix npm lint configuration`
  - `e7a384d` `Hide page content when mobile menu is open`

## Runtime verification and PR readiness

- The paste-ready PR comments from the prior Cursor handover have not been used yet.
- Before using those comments, run local runtime verification on:
  - Divi 4 + plugin defaults.
  - Divi 5 + plugin defaults.
  - Keyboard-only traversal for skip link, primary/submenu nav, slider controls, and contact form feedback.
  - Screen reader smoke checks for slider labels and contact form success/error messaging.
- After verification, regenerate concise PR-ready comments for the relevant branches/PRs instead of reusing the old notes blindly.

## Items identified from `ref/divi-assistant` and the article

- High-priority candidates to port into this plugin:
  - Hide page content from screen readers while the mobile menu is open.
  - Sync/override/fallback alt text from the WordPress media library into Divi modules.
  - Improve Divi contact form checkbox accessibility.
  - Improve accessible names/support for search and cart icons in navigation.
  - Increase slider navigation dot spacing/touch target size.
- Lower-priority or likely not core to this plugin:
  - Hide skip link for non-screen readers.
  - Back-to-top appearance tooling.

## Styling strategy

- Keep styling owned by this plugin.
- Use active Divi version detection only to scope narrow compatibility overrides.
- Do not import theme styling directly from Divi or from `ref/divi-assistant`.
- Only split into larger per-version plugin stylesheets if the compatibility layer becomes materially larger or riskier to maintain inline.

## Divi 5 module settings

- Current module-level Accessibility Settings are still implemented via builder hooks:
  - `et_builder_module_general_fields`
  - `et_builder_get_parent_modules`
  - `et_builder_get_child_modules`
- Divi 5 implementation path now added in this repo:
  - Registers a Visual Builder package build to inject module settings in D5.
  - Adds an `Accessibility Settings` group in the D5 Advanced panel.
  - Adds D5 fields for `Hide From Screen Readers` and `Show For Screen Readers Only`.
  - Maps legacy D4 attrs into `accessibility.advanced.*` during D4 to D5 conversion.
- Required verification:
  - Confirm the two module toggles appear in Divi 5 across representative modules.
  - Confirm values persist after save/reopen in the Divi 5 builder.
  - Confirm converted D4 content keeps the settings after migration to D5.
  - Confirm frontend output still adds `aria-hidden` and `screen-reader-text` classes from D5 nested attrs.

## Next implementation order

1. Runtime-verify Divi 5 module-level Accessibility Settings behavior.
2. Add slider dot spacing compatibility as plugin-owned CSS.
3. Port contact form checkbox accessibility improvements.
4. Design and implement alt-text sync/override/fallback for Divi modules.
