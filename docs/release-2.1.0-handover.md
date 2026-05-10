# Release Handover

Prepared: 2026-04-24
Last updated: 2026-05-10

## Historical State

This handover is historical. Use `docs/roadmap-next-actions.md` and the latest `docs/afk-batch-*` note for the current maintained-fork release state.

`2.1.3` was the current maintained-fork release when this handover was prepared. It built on the final `2.1.0` compatibility release, kept the `2.1.1` fork-only GitHub Releases updater, included the `2.1.2` skip-link visibility fix, and added expanded skip links, focused module ARIA fields, guardrails, docs, and pragmatic CI/release checks.

- Historical `2.1.3` release: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.3>
- Historical `2.1.3` zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.3/divi-accessibility-2.1.3.zip>
- Historical `2.1.3` zip SHA-256: `9f20f1881d039f9f110e72b6b06950ed9575fac052ecfedfff6c55cc4c747a69`
- Historical `2.1.3` release tag target: `0680c0a`
- Historical `2.1.3` release commit: `0680c0a`

`2.1.1` was the bootstrap updater release. Sites already on `2.1.0` needed to install `2.1.1` manually once because `2.1.0` did not contain the updater. Later releases can appear in WordPress' normal Plugins update screen when the GitHub Release includes the required packaged assets for that release line.

`2.1.0` remains the final upstream-safe compatibility release associated with CampusPress PR `#121`.

- `2.1.0` release: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
- `2.1.0` zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
- `2.1.0` zip SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`
- `2.1.0` release tag target: `2ce67b8`
- Final docs closeout commit: `150041f`
- Upstream PR: <https://github.com/campuspress/divi-accessibility/pull/121>
- Upstream PR status after `2.1.1`: open, ready for review, clean, and mergeable at `c27c424`.
- Upstream repository permission for this account: read-only, so upstream issues cannot be closed directly.

The final `2.1.0` release asset was RC7 promoted unchanged. Do not rebuild or replace the historical `2.1.0`, `2.1.1`, or `2.1.2` release assets unless a code/package defect is found and a new release is intentionally cut.

## Release Scope

This release keeps the plugin GPL-compatible and preserves original CampusPress credit while documenting the maintained fork as the practical release path unless CampusPress or WordPress.org grants ownership/committer access.

Included in `2.1.0`:

- Divi 5 module-level Accessibility Settings support.
- Divi 5 frontend output support for saved module accessibility settings.
- D4-to-D5 migrated content compatibility for legacy module attributes.
- Divi 4 runtime compatibility preservation.
- Mobile menu screen-reader isolation and submenu state synchronization.
- Slider labels, keyboard parity, and active-dot state.
- Contact-form invalid-state and live-region updates.
- Toggle/accordion button semantics and expanded-state synchronization.
- Tabs keyboard/panel state synchronization.
- `tota11y` default handling fix.
- Release packaging, GPL metadata, README/readme ownership language, and final GitHub release assets.

Included in `2.1.1`:

- Native WordPress plugin updater that checks stable GitHub Releases for `RichardGeorgeDavis/divi-accessibility`.
- WordPress update transient and plugin information modal integration for newer packaged fork releases.
- Exact package-asset matching for `divi-accessibility-{version}.zip`.
- Draft, prerelease, non-semver tag, source archive, and missing-package release rejection.
- No site URL in GitHub updater request headers.
- README cleanup removing WordPress.org version/download badges that pointed to the closed listing.

Included in `2.1.2`:

- Dedicated skip-link CSS that keeps the plugin-inserted skip link visually hidden until focus/activation even when the broader screen-reader-text option is disabled.
- Admin copy cleanup removing the outdated note that the skip navigation link requires the screen reader text option.

Included in `2.1.3`:

- Configurable skip links for navigation, content, and footer targets while preserving the existing content-only default behavior.
- Focused Divi 4 module ARIA fields for wrapper-level role, labels, descriptions, and details, with Divi 5 migrated-content render parity.
- Guardrails and admin guidance for plugin-owned module ARIA fields.
- Module support matrix and manual accessibility checklist documentation.
- Pragmatic GitHub Actions CI and non-mutating release metadata validation.

Not included:

- MIT relicensing.
- Broad UI refresh work.
- Alt-text roadmap work.
- Preview scanner work.
- Full third-party module compatibility certification.
- WordPress.org ownership or official continuity claims.

## Verification Summary

Final `2.1.0` gates passed before release:

- `npm run lint`
- `npm run package`
- PHP syntax checks on touched PHP files
- zip content inspection
- final zip hash verification
- install/activate/deactivate/reactivate smoke test from packaged zip
- Divi 5 Visual Builder setting visibility
- Divi 5 save/reopen persistence for both module accessibility toggles
- Divi 5 frontend output for saved `Hide From Screen Readers` and `Show For Screen Readers Only`
- D4-authored legacy module attributes preserved after Divi 5 migration
- Divi 4 smoke checks for skip link, keyboard focus outline, mobile menu, submenus, sliders, contact form, toggle/accordion, and module accessibility attributes

`2.1.1` updater verification:

- `npm run release`
- `npm run package`
- `php -l includes/class-divi-accessibility-updater.php`
- updater normalization checks:
  - accepts latest stable `2.1.1` release with exact `divi-accessibility-2.1.1.zip`
  - rejects mismatched packaged zip names
  - rejects RC-style tags
- zip content inspection
- GitHub release asset digest verified as `sha256:84fcf2acdd5fcfb0ae00561a1f73be6acf5ead3efeeb048f9218742919f6019f`
- live GitHub `/releases/latest` response normalizes to the `2.1.1` package

`2.1.2` skip-link release verification:

- `DA11Y_RELEASE_VERSION=2.1.2 DA11Y_ASSUME_YES=true npm run release`
- generated package: `packaged/divi-accessibility-2.1.2.zip`
- generated package SHA-256: `d46b8be539c0e3abac4920c86be110903bfe34033062f5a1ddbb68512ff8fb22`

`2.1.3` maintenance release verification:

- `git ls-files '*.php' | xargs -n 1 php -l`
- `npm ci`
- `npm run lint`
- `npm run build`
- `npm run i18n`
- `npm run release:check`
- `DA11Y_RELEASE_VERSION=2.1.3 DA11Y_ASSUME_YES=true npm run release`
- generated package: `packaged/divi-accessibility-2.1.3.zip`
- GitHub release asset digest verified as `sha256:9f20f1881d039f9f110e72b6b06950ed9575fac052ecfedfff6c55cc4c747a69`

No manual Divi 4 or Divi 5 browser runtime checks were run specifically for `2.1.3`; use `docs/testing/manual-accessibility-checklist.md` before claiming new runtime coverage for this release.

Known limits:

- Search/cart/header markup varies by Divi header configuration and should keep receiving validation on real user reports.
- Mega-menu, reverse-tab, iframe, and third-party plugin-specific reports need targeted repro pages before closure.
- WooCommerce store-only/coming-soon templates that do not print normal footer scripts cannot run footer-enqueued plugin JavaScript on those responses.
- Contact form checkbox behavior should still be validated against both checkbox-list and boolean-checkbox field types.
- Official WordPress.org takeover may be denied because the original listing was closed by author request.
- Sites on `2.1.0` cannot auto-detect `2.1.1`; the updater starts after `2.1.1` is installed.

## Upstream And Issue Closeout

Final upstream PR comment was posted on `#121` with the final release URL, zip URL, SHA-256, and runtime summary:

- <https://github.com/campuspress/divi-accessibility/pull/121#issuecomment-4312815885>

Issues already closed during this work:

- `#112` Slider labels/keyboard parity
- `#114` Contact form announcements
- `#107` Stale upstream branch/PR cleanup

Direct closure candidates, but only maintainers can close them upstream:

- `#90` Undefined `$tota11y` warning
- `#96` Divi 5 support
- `#88` module accessibility toggles
- `#78` missing module accessibility attribute warnings
- `#57` installable zip question

Validation-only issues that should remain open until reporter or maintainer confirmation:

- `#122`
- `#91`
- `#51`
- `#71`
- `#69`
- `#60`
- `#94`
- `#85`
- `#81`
- `#76`
- `#73`
- `#72`
- `#56`
- `#53`
- `#31`
- `#25`
- `#23`
- `#21`
- `#7`

Backlog/planning issues should remain open unless maintainers decide otherwise:

- `#104`
- `#103`
- `#102`
- `#75`
- `#74`
- `#59`
- `#58`
- `#52`
- `#50`
- `#19`

Reference documents:

- `docs/upstream-triage-map.md`
- `docs/github-issue-closeout-comments.md`
- `docs/takeover-adoption-package.md`

## License Decision

Do not switch the plugin to MIT.

The existing plugin is a derivative work with original CampusPress/contributor GPL-licensed code. The maintained fork should remain `GPL-2.0-or-later` unless all relevant copyright holders grant relicensing rights. New standalone tooling written entirely by the fork maintainer can be separately licensed later if needed, but the plugin package, `divi-accessibility.php`, `readme.txt`, `package.json`, `LICENSE`, and `license.txt` should stay GPL-compatible.

## Branch State

Keep:

- `master` as the maintained-fork release branch.
- `codex/divi4-divi5-style-compat` until upstream PR `#121` is merged or explicitly abandoned.

Do not merge old `codex/*` feature branches into `master`; the verified release branch already contains the release-relevant work.

Do not push `2.1.1` updater changes to `codex/divi4-divi5-style-compat` or upstream PR `#121` unless maintainers explicitly ask for fork-updater behavior. The updater points at the maintained fork and is intentionally fork-only.

Use `docs/branch-cleanup-after-2.1.0.md` for a later explicit branch cleanup batch. Do not delete branches as part of this handover.

## Next Owner Actions

1. Monitor upstream PR `#121` for maintainer feedback.
2. If CampusPress responds, keep the merge path focused on `#121`; avoid adding unrelated backlog work to that PR.
3. If reporters respond on validation issues, triage against the current maintained-fork release first and open focused follow-up work only when the original repro still fails.
4. Contact CampusPress/original maintainers for GitHub maintainer access or WordPress.org plugin transfer.
5. If direct transfer is not available, prepare the WordPress.org adoption request using `docs/takeover-adoption-package.md`.
6. Keep publishing future maintained-fork releases from `master` unless official ownership is granted.
7. Run branch cleanup only as a separate explicit task after confirming no cached worktrees or unpushed notes are needed.

## Public Messaging Rules

- Refer to this as a maintained fork unless CampusPress or WordPress.org grants official access.
- Preserve original CampusPress creator credit.
- Do not claim official WordPress.org continuity.
- Do not include local site URLs, client names, or local filesystem paths in public README, release notes, PR comments, issue comments, or adoption documents.
- Use the current release URL and SHA-256 above when pointing users at the installable package.
- Explain that `2.1.1` must be installed manually once before future fork updates can appear in WordPress.
