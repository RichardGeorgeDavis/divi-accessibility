# Roadmap / Next Actions

## Current 2.1.7 State

- Current maintained-fork release target: `2.1.7`
- Current published maintained-fork release before this batch: `2.1.6`
- Current release URL before this batch: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.6>
- `2.1.7` hardens the GitHub Releases updater by requiring exact zip and `.zip.sha256` assets, verifying update downloads before install, preserving saved settings while merging new defaults, fixing packaged translation loading, and documenting stale-status cleanup.
- The published `2.1.6` release has the packaged zip asset only. Checksum assets are required for updater-compatible releases starting with `2.1.7`.
- The latest recorded full manual browser integration evidence remains from the `2.1.0` release line; use `docs/testing/manual-accessibility-checklist.md` before updating runtime-tested claims.

## Current Next Actions

- Publish `2.1.7` with both `divi-accessibility-2.1.7.zip` and `divi-accessibility-2.1.7.zip.sha256` assets.
- Run the manual checklist against `2.1.7` on Divi 4 and Divi 5 test sites before changing runtime-tested claims.
- Update `docs/module-support-matrix.md` with exact Divi, WordPress, PHP, browser, WooCommerce, and Divi Pixel versions only after completing those checks.
- Triage any reporter feedback against the current maintained-fork release first, then open focused follow-up work only when the original repro still fails.
- Monitor CI on `origin/master` and keep `npm run release:check` green before the next release.
- Continue the official-access track with CampusPress/WordPress.org while treating the fork release as the practical user install path.

## Historical 2.1.3 Notes

`2.1.3` added expanded skip links, focused module ARIA fields, ARIA guardrails/guidance, module support/testing docs, GitHub Actions CI, and `npm run release:check`. Those notes are historical and should not be used to select a current downloadable artifact.

## Historical 2.1.0 Closeout Notes

The sections below preserve the `2.1.0` release and upstream PR history. They are not the current release checklist and should not be used to select a downloadable artifact.

## Phase 1: Close Out 2.1.0 Work

- Completed:
  - Divi 5 module-level `Accessibility Settings` support is in place.
  - Mobile menu screen-reader isolation is in place.
  - Slider accessibility and reduced motion support are in place.
  - Contact form live-region and invalid-state syncing are in place.
  - Release metadata was aligned on `2.1.0`.
  - Package output now includes `languages/`.
  - npm lint now covers both public JS and admin-side Divi 5 builder JS.
  - Release docs, handover notes, and PR notes were added under `docs/`.
  - Upstream draft PR `#121` has been updated with current summary, testing requests, and packaged-build download links.
  - A downloadable prerelease test build was published on the fork.
  - The `tota11y` undefined-variable fix was folded into the current branch.
  - Takeover/adoption package added at `docs/takeover-adoption-package.md`.
  - Packaged-plugin install/activate/deactivate/reactivate smoke passed on a LocalWP Divi 5 site.
  - Issue `#122` navbar/submenu follow-up found and fixed a Divi 5 keyboard state mismatch.
  - Divi draft module page follow-up found and fixed a tabs panel `aria-hidden` state mismatch.
  - Maintained-fork ownership and GPL-compatible release metadata cleanup completed.
  - Upstream issue/PR triage map added at `docs/upstream-triage-map.md`.
- Historical remaining items were completed before the final `2.1.0` upstream-ready summary was posted, except for broader reporter validation on site-specific menu/header variants.

## Phase 1.5: Package And Validate The Plugin

- Completed:
  - `packaged/divi-accessibility-2.1.0.zip` builds successfully.
  - Zip contents were checked for the expected plugin files.
  - The package no longer includes `.DS_Store`.
- Completed in this environment:
  - Local WordPress package install and activation smoke check on a local Divi 5 package-smoke site.
  - Local WordPress deactivate/reactivate smoke check.
  - Frontend response confirms Divi Accessibility payload is rendered for Divi 5.
  - Divi 5 navbar/submenu focus behavior related to issue `#122` now keeps visible state and `aria-expanded` synchronized.
  - Divi 5 module page checks now cover sliders, contact forms, tabs, and toggles/accordions.
- Still blocked or incomplete in this environment:
  - Divi 4 runtime matrix execution.
  - Divi 5 Visual Builder save/reopen persistence automation.
- Current blocker:
  - Deeper builder/runtime verification still needs manual browser interaction and/or a dedicated Divi 4 test site.
- Manual progress since that automation attempt:
  - visual pass completed for frontend tabs
  - visual pass completed for Divi 5 Visual Builder `Accessibility Settings` visibility
- Historical `2.1.0` runtime tasks are complete or superseded by the final `2.1.0` release. Do not use old `codex-2.1.0-rc*` prerelease assets for new testing.

## Phase 1.75: Upstream Adoption / Fork Continuity

- Current status:
  - Upstream PR `#121` is closed as of the 2026-05-10 status check.
  - WordPress.org lists `accessible-divi` as closed since 2020-05-12 with closure reason `Author Request`.
- Adopted path:
  - dual track: pursue official adoption or maintainer access while keeping the fork usable as the practical release path.
- Next actions:
  - use `docs/takeover-adoption-package.md` to contact CampusPress/original maintainers
  - prepare a WordPress.org Plugin Review Team adoption request only after direct contact attempts are documented
  - maintain a renamed fork if official adoption is denied

## Phase 2: Documentation Refresh

- Completed:
  - `README.md` updated for Divi 4/5 support and the maintained-fork release path.
  - `readme.txt` updated for release metadata, FAQ, and changelog.
  - POT metadata regenerated through the current maintained-fork release line.
  - Admin resources updated to current WCAG/WAI references.
  - Internal release checklist, handover, and PR notes added.

## Phase 2.5: Feedback From Packaging/Runtime

- Completed:
  - Packaging feedback applied:
    - translations included in zip
    - POT generation excludes `ref/`
    - release command path works end-to-end
    - package output moved to `packaged/`
- Pending:
  - apply findings from fresh manual WordPress/Divi runtime verification.

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
  - Evaluate Divi-specific cherry-picks inspired by `joedolson/wp-accessibility` ([https://github.com/joedolson/wp-accessibility](https://github.com/joedolson/wp-accessibility)), limited to `aria-current` for active menu links, autoplay-video pause/play controls, and alt-text quality heuristics that feed the planned Divi alt-text sync work
  - Do not port the generic WordPress utility layer, accessibility toolbar, stats, longdesc UI, title stripping, target stripping, or broad overlay/remediation settings
  - Keep any adopted behavior scoped to Divi-rendered output and existing Divi Accessibility settings
  - Evaluate a Divi-focused preview review mode inspired by `campuspress/accessible-content` ([https://github.com/campuspress/accessible-content](https://github.com/campuspress/accessible-content)), limited to admin-only preview scanning, issue navigation, and per-post ignored findings
  - Do not port `accessible-content` wholesale; keep this plugin focused on Divi-specific rendered-output issues
  - Defer media-library alt/decorative management and Gutenberg-specific editor extensions unless they become necessary for the Divi alt-text sync work
  - Decide whether additional appearance compatibility work should stay in the shared layer or split into clearer Divi 4/Divi 5 stylesheets
  - Expand runtime coverage around migrated D4-to-D5 content
- Likely first-pass cherry-picks from `wp-accessibility`:
  - `aria-current="page"` on active nav links, suspicious/invalid/long alt-text heuristics, and optional controls for autoplaying videos without native controls
- Likely first-pass checks for that future review mode:
  - missing `alt`, heading skips/multiple `h1`, unlabeled controls, untitled iframes, and duplicate IDs in preview content

## Handover State

- Current upstream PR: `#121` is closed
- Upstream PR head at 2026-04-24 status check: `75003ef`
- Current maintained-fork release target: `2.1.7`
- Historical `2.1.0` RC builds are superseded.
- Immediate handover action:
  - run the manual accessibility checklist on Divi 4 and Divi 5 for the current release
  - update the support matrix with exact tested versions
  - keep the official-access history available without treating old upstream PR state as current
