# Release 2.1.0 Handover

Prepared: 2026-04-24

## Current State

`2.1.0` is the final maintained-fork release for the Divi Accessibility compatibility and accessibility maintenance work.

- Final release: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/2.1.0>
- Final zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/2.1.0/divi-accessibility-2.1.0.zip>
- Final zip SHA-256: `69c25e3bbda5d033dacda63ae4814c263c2afa4583be5ac5635caef36109faef`
- Final release tag target: `2ce67b8`
- Final docs closeout commit: `150041f`
- Upstream PR: <https://github.com/campuspress/divi-accessibility/pull/121>
- Upstream PR status at closeout: open, ready for review, clean, and mergeable.
- Upstream repository permission for this account: read-only, so upstream issues cannot be closed directly.

The final `2.1.0` release asset is RC7 promoted unchanged. Do not rebuild or replace the release asset unless a code/package defect is found and a new release is intentionally cut.

## Release Scope

This release keeps the plugin GPL-compatible and preserves original CampusPress credit while documenting the maintained fork as the practical release path unless CampusPress or WordPress.org grants ownership/committer access.

Included work:

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

Not included:

- MIT relicensing.
- Broad UI refresh work.
- Alt-text roadmap work.
- Preview scanner work.
- Full third-party module compatibility certification.
- WordPress.org ownership or official continuity claims.

## Verification Summary

Final gates passed before release:

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

Known limits:

- Search/cart/header markup varies by Divi header configuration and should keep receiving validation on real user reports.
- Mega-menu, reverse-tab, iframe, and third-party plugin-specific reports need targeted repro pages before closure.
- WooCommerce store-only/coming-soon templates that do not print normal footer scripts cannot run footer-enqueued plugin JavaScript on those responses.
- Contact form checkbox behavior should still be validated against both checkbox-list and boolean-checkbox field types.
- Official WordPress.org takeover may be denied because the original listing was closed by author request.

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

## Branch State

Keep:

- `master` as the maintained-fork release branch.
- `codex/divi4-divi5-style-compat` until upstream PR `#121` is merged or explicitly abandoned.

Do not merge old `codex/*` feature branches into `master`; the verified release branch already contains the release-relevant work.

Use `docs/branch-cleanup-after-2.1.0.md` for a later explicit branch cleanup batch. Do not delete branches as part of this handover.

## Next Owner Actions

1. Monitor upstream PR `#121` for maintainer feedback.
2. If CampusPress responds, keep the merge path focused on `#121`; avoid adding unrelated backlog work to that PR.
3. If reporters respond on validation issues, triage against `2.1.0` first and open focused follow-up work only when the original repro still fails.
4. Contact CampusPress/original maintainers for GitHub maintainer access or WordPress.org plugin transfer.
5. If direct transfer is not available, prepare the WordPress.org adoption request using `docs/takeover-adoption-package.md`.
6. Keep publishing future maintained-fork releases from `master` unless official ownership is granted.
7. Run branch cleanup only as a separate explicit task after confirming no cached worktrees or unpushed notes are needed.

## Public Messaging Rules

- Refer to this as a maintained fork unless CampusPress or WordPress.org grants official access.
- Preserve original CampusPress creator credit.
- Do not claim official WordPress.org continuity.
- Do not include local site URLs, client names, or local filesystem paths in public README, release notes, PR comments, issue comments, or adoption documents.
- Use the final release URL and SHA-256 above when pointing users at the installable package.
