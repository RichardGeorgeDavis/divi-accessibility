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
- Upstream PR head at 2026-04-24 status check: `75003ef`
- Upstream draft PR: `#121` <https://github.com/campuspress/divi-accessibility/pull/121>
- Takeover/adoption package: `docs/takeover-adoption-package.md`
- AFK batch evidence: `docs/afk-batch-2026-04-24.md`
- Downloadable packaged test build:
  - current release page: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/codex-2.1.0-rc2>
  - current zip asset: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/download/codex-2.1.0-rc2/divi-accessibility-2.1.0.zip>
  - current zip SHA-256: `b9e550840eb807e5d35e4dfc154c24c084f20caf864baf31280616f52c0ff6fc`
  - previous superseded build: `codex-2.1.0-rc1`

## Commit Lineage On This Branch

- `395b4b4` Add minimal Divi 4/5 styling compatibility layer.
- `227c133` Add slider and reduced-motion accessibility support.
- `3124b7b` Fix npm lint configuration.
- `e7a384d` Hide page content when mobile menu is open.
- `a721e9e` Add Divi 5 module accessibility settings support.
- `7938dc6` Prepare 2.1.0 release candidate.
- `7a59685` Write packages to packaged directory.
- `3f4cf7a` Record visual verification progress.
- `c35a85f` Document remaining verification tasks.
- `de40c78` Fix tota11y default handling.
- `75003ef` Refresh release handover docs.

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

## What Has Been Verified

- `npm run lint`
- `npm run build`
- `npm run i18n`
- `npm run release`
- package zip generation and zip content inspection
- packaged-plugin install, activate, deactivate, and reactivate smoke check on LocalWP `Master Licenses`
- frontend response from `http://master.local/` includes Divi Accessibility payload for Divi 5
- targeted `php -l` and `node --check`
- manual visual pass:
  - frontend tabs working
  - Divi 5 Visual Builder modules show `Accessibility Settings`

## Upstream Cleanup Already Done

- superseded draft PRs closed:
  - `#119`
  - `#118`
  - `#117`
  - `#116`
  - `#110`
  - `#109`
  - `#97`
- related issues updated to point at `#121`
- issues closed as already resolved by `#121`:
  - `#120`
  - `#115`
  - `#113`
  - `#101`
  - `#100`
- issue `#90` is fixed in code and linked to `#121`, but could not be closed directly due upstream permissions
- maintainer follow-up posted on `#121` on 2026-04-16 with review, merge, and issue-closure asks
- RC2 verification progress posted on `#121` on 2026-04-24:
  - <https://github.com/campuspress/divi-accessibility/pull/121#issuecomment-4311364696>
- upstream issue `#122` opened on 2026-04-14 and should be included in the runtime follow-up matrix

## Next Steps

1. Publish or share a refreshed fork prerelease asset if external testers need a package newer than `codex-2.1.0-rc1`.
2. Run the remaining runtime checks:
   - Divi 5 toggle persistence after save/reopen
   - frontend verification for slider, mobile menu, search/cart controls, and contact forms
   - navbar/submenu visibility and announcements related to issue `#122`
   - Divi 4 backward compatibility
   - one migrated D4-to-D5 content case
3. Update `docs/release-2.1.0-pr-notes.md` with final runtime results.
4. Post the final runtime result summary to upstream PR `#121`.
5. Ask a maintainer to close issue `#90` if satisfied with the fix now in `#121`.
6. Decide whether the remaining older open PRs (`#111`, `#108`, `#106`, `#105`, `#99`, `#98`) should be folded into `#121` or kept as follow-up work.
7. If there is still no upstream response after runtime verification, use `docs/takeover-adoption-package.md` to contact CampusPress and prepare the WordPress.org adoption request.

## Known Residual Risks

- Full Divi 4/Divi 5 runtime verification still depends on manual WordPress and builder checks.
- Search/cart control markup varies by theme/header configuration, so runtime validation should include default header and menu-module variants.
- Contact form checkbox behavior should be verified against both checkbox list and boolean checkbox field types.
- The `codex-2.1.0-rc1` downloadable test build asset was generated before the later `de40c78` tota11y follow-up fix; external testers should use `codex-2.1.0-rc2`.
- WordPress.org lists `accessible-divi` as permanently closed by author request, so official adoption may require CampusPress approval or may be denied by the Plugin Review Team.
