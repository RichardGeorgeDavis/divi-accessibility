# Roadmap / Next Actions

## Current 2.1.11.1 State

- Latest published maintained-fork release: `2.1.11.1`
- Published release URL: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.11.1>
- Release commit: `30339c8c5ee9a363093a675771420bdd65f35d98`
- `2.1.11.1` is a release-patch for CI-state consistency: generated translation artifacts were refreshed and the release metadata/package artifacts were republished cleanly.
- The published `2.1.11.1` release has both `divi-accessibility-2.1.11.1.zip` and `divi-accessibility-2.1.11.1.zip.sha256`; the verified package SHA-256 is `21ca5633746c520c7a446b32c81b423d183b7783d5ad8d5e7bc09f77104fec7e`.
- `2.1.11` adds feature-gated asset loading, skip-link visibility controls, slider navigation spacing, and pinch-zoom controls.
- `2.1.10` plus earlier maintained-fork metadata checks remain the previous baseline for behavior changes.
- `2.1.7` hardens the GitHub Releases updater by requiring exact zip and `.zip.sha256` assets, verifying update downloads before install, preserving saved settings while merging new defaults, fixing packaged translation loading, and documenting stale-status cleanup.
- The historical `2.1.6` release has the packaged zip asset only. Checksum assets are required for updater-compatible releases starting with `2.1.7`.
- Local `2.1.11.1` package smoke passed for install/build/close checks through CI. Dedicated multi-version runtime evidence is still pending manual capture.

## Current Next Actions

- Ask reporters or maintainers to validate open accessibility regressions against the published `2.1.11.1` package.
- Watch the docs-only post-release closeout CI run before considering the batch fully settled.
- Keep manual evidence dated and versioned. Do not broaden runtime-tested claims from static checks, package checks, or stale release notes.
- Keep stale cached worktrees and unmerged local branches untouched until each has an explicit cleanup disposition.
- Keep `npm run release:check` green before the next release.
- Continue the official-access track with CampusPress/WordPress.org while treating the fork release as the practical user install path.

## Standard Release + Handover Process

- Bump versions in `package.json`, `package-lock.json`, `divi-accessibility.php`, and `readme.txt` in one pass.
- Update changelog entries in both `readme.txt` and `README.md`.
- Refresh generated assets with `npm run i18n` and `npm run build`.
- Run release validation with `npm run release:check` (or `DA11Y_RELEASE_VERSION=<version> npm run release:check`).
- Rebuild package artifacts with `npm run package`.
- Commit release metadata + docs changes, then tag the exact commit as the release version.
- Create/refresh GitHub release with:
  - `divi-accessibility-<version>.zip`
  - `divi-accessibility-<version>.zip.sha256`
- Update this document’s “Current … State” block (release number, commit hash, release URL, checksum, next action).
- If runtime evidence changed, update `docs/module-support-matrix.md` and include evidence date + environment details.
- Push and verify the CI result is green on the release commit before closing the batch.
- For follow-up maintenance release (like `2.1.11.1`), add a concise handover note that it is intentionally patch-only and what changed.

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
  - packaged `2.1.7` runtime smoke completed on local Divi 4 and Divi 5 sites
  - focused `2.1.7` manual module matrix completed on local Divi 4 and Divi 5 sites

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
- Current maintained-fork release: `2.1.11.1`
- Historical `2.1.0` RC builds are superseded.
- Immediate handover action:
  - use the release notes in `readme.txt` and the clean CI run (`CI` for commit `30339c8`) as the current acceptance baseline
  - open follow-up code work only for reproducible defects against the packaged `2.1.11.1` zip and validated behavior notes
  - keep the official-access history available without treating old upstream PR state as current
