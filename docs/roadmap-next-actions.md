# Roadmap / Next Actions

## Phase 1: Close Out Current Work

- Completed:
  - Divi 5 module-level `Accessibility Settings` support is in place.
  - Mobile menu screen-reader isolation is in place.
  - Slider accessibility and reduced motion support are in place.
  - Contact form live-region and invalid-state syncing are in place.
  - Release metadata is aligned on `2.1.0`.
  - Package output now includes `languages/`.
  - npm lint now covers both public JS and admin-side Divi 5 builder JS.
  - Release docs, handover notes, and PR notes were added under `docs/`.
- Still required before upstream integration:
  - Run manual Divi 4 and Divi 5 runtime checks in WordPress.
  - Use the updated PR notes after runtime verification, not the earlier Cursor notes.
  - Complete persistence checks after save/reopen in Divi 5.
  - Complete packaged-plugin validation rather than relying on source-checkout behavior.
  - Update PR notes with final runtime results only after verification is complete.
  - Use the finalized PR notes for upstream review once verification is complete.

## Phase 1.5: Package And Validate The Plugin

- Completed:
  - `packaged/divi-accessibility-2.1.0.zip` builds successfully.
  - Zip contents were checked for the expected plugin files.
  - The package no longer includes `.DS_Store`.
- Blocked in this environment:
  - Local WordPress package install and activation.
  - Divi 4/Divi 5 runtime matrix execution.
- Current blocker:
  - Available Local WordPress sites did not have a live database connection during automation attempts.
- Manual progress since that automation attempt:
  - visual pass completed for frontend tabs
  - visual pass completed for Divi 5 Visual Builder `Accessibility Settings` visibility
- Explicit next runtime tasks:
  - install and activate `packaged/divi-accessibility-2.1.0.zip`
  - verify Divi 5 toggle persistence after save/reopen
  - verify frontend behavior on slider, mobile menu, search/cart controls, and contact forms
  - verify Divi 4 backward compatibility
  - verify one migrated D4-to-D5 content case

## Phase 2: Documentation Refresh

- Completed:
  - `README.md` updated for Divi 4/5 support and the `2.1.0` release path.
  - `readme.txt` updated for release metadata, FAQ, and changelog.
  - POT metadata regenerated at `2.1.0`.
  - Admin resources updated to current WCAG/WAI references.
  - Internal release checklist, handover, and PR notes added.

## Phase 2.5: Feedback From Packaging/Runtime

- Completed:
  - Packaging feedback applied:
    - translations included in zip
    - POT generation excludes `ref/`
    - release command path works end-to-end
- Pending:
  - apply any findings from manual WordPress/Divi runtime verification

## Phase 3: Quick Wins

- Completed:
  - Slider navigation dot target sizing via plugin-owned CSS
  - Improved accessible names for search and cart controls
  - Improved contact form checkbox keyboard accessibility
- Remaining candidate:
  - Alt-text sync/override/fallback from the WordPress media library into Divi modules

## Phase 4: Modernization And Structure

- Completed:
  - Divi-version-specific compatibility remains plugin-owned and version-scoped
  - Release/package/docs/tooling are substantially more modernized than the pre-`2.1.0` branch state
- Next structural work after release validation:
  - Implement alt-text sync/override/fallback
  - Decide whether additional appearance compatibility work should stay in the shared layer or split into clearer Divi 4/Divi 5 stylesheets
  - Expand runtime coverage around migrated D4-to-D5 content
