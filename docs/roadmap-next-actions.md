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
  - Upstream draft PR `#121` has been updated with current summary, testing requests, and packaged-build download links.
  - A downloadable prerelease test build was published on the fork.
  - The `tota11y` undefined-variable fix was folded into the current branch.
  - Takeover/adoption package added at `docs/takeover-adoption-package.md`.
  - Packaged-plugin install/activate/deactivate/reactivate smoke passed on a LocalWP Divi 5 site.
  - Issue `#122` navbar/submenu follow-up found and fixed a Divi 5 keyboard state mismatch.
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
- Completed in this environment:
  - Local WordPress package install and activation smoke check on `Master Licenses`.
  - Local WordPress deactivate/reactivate smoke check.
  - Frontend response confirms Divi Accessibility payload is rendered for Divi 5.
  - Divi 5 navbar/submenu focus behavior related to issue `#122` now keeps visible state and `aria-expanded` synchronized.
- Still blocked or incomplete in this environment:
  - Divi 4 runtime matrix execution.
  - Divi 5 Visual Builder save/reopen persistence automation.
- Current blocker:
  - Deeper builder/runtime verification still needs manual browser interaction and/or a dedicated Divi 4 test site.
- Manual progress since that automation attempt:
  - visual pass completed for frontend tabs
  - visual pass completed for Divi 5 Visual Builder `Accessibility Settings` visibility
- Explicit next runtime tasks:
  - install and activate `packaged/divi-accessibility-2.1.0.zip`
  - publish/use refreshed `codex-2.1.0-rc3` asset for testers
  - verify Divi 5 toggle persistence after save/reopen
  - verify frontend behavior on slider, mobile menu, search/cart controls, and contact forms
  - verify Divi 4 backward compatibility
  - verify one migrated D4-to-D5 content case
  - use refreshed packaged artifact `codex-2.1.0-rc3` for any external tester pass

## Phase 1.75: Upstream Adoption / Fork Continuity

- Current status:
  - Upstream PR `#121` has no maintainer review, assignee, or requested reviewer as of 2026-04-24.
  - Maintainer follow-up was posted on `#121` on 2026-04-16.
  - WordPress.org lists `accessible-divi` as closed since 2020-05-12 with closure reason `Author Request`.
- Adopted path:
  - dual track: pursue official adoption or maintainer access while keeping the fork usable as the practical release path.
- Next actions:
  - complete runtime verification before posting any final readiness claim
  - if there is still no upstream response after verification, use `docs/takeover-adoption-package.md` to contact CampusPress/original maintainers
  - prepare a WordPress.org Plugin Review Team adoption request only after direct contact attempts are documented
  - maintain a renamed fork if official adoption is denied

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
    - package output moved to `packaged/`
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

- Current upstream draft PR: `#121`
- Upstream PR head at 2026-04-24 status check: `75003ef`
- Current downloadable test build: `codex-2.1.0-rc3`
- Immediate handover action:
  - complete runtime verification
  - update PR notes with final results
  - post final runtime summary on `#121`
