# Release 2.1.0 Checklist

## Current Verification Status

- Manual visual pass completed:
  - frontend tabs are working
  - Divi 5 Visual Builder modules show `Accessibility Settings`
- Packaged-plugin smoke completed on LocalWP `Master Licenses`:
  - WordPress `6.9.4`
  - Divi `5.3.3`
  - install, activate, deactivate, and reactivate passed
  - frontend rendered plugin payload with `da11y-divi-5`, `_da11y.version` `2.1.0`, skip-link, slider, submenu, and mobile-menu scripts/styles
- Additional code-level follow-up completed:
  - issue `#90` (`tota11y` undefined-variable path) fixed in branch head `de40c78`
- Still pending:
  - persistence checks after save/reopen
  - broader module-type coverage across Divi 4, Divi 5, and migrated D4-to-D5 content

## Remaining Tasks To Perform

- complete deeper packaged-plugin behavior checks beyond the install/activate smoke pass
- verify Divi 5 toggle persistence after save/reopen
- verify slider, mobile menu, search/cart controls, and contact form behaviors on real pages
- verify navbar/submenu visibility and announcement behavior related to upstream issue `#122`
- verify Divi 4 backward compatibility
- verify one migrated D4-to-D5 content case
- update PR notes with final runtime results only after the checks above are complete
- ask a maintainer to close upstream issue `#90` after reviewing the fix already linked from `#121`

## Static Checks

- `npm run lint`
- `npm run build`
- `npm run i18n`
- `php -l` on touched PHP files
- release/package dry run
- zip content inspection

## Package Checks

- build `packaged/divi-accessibility-2.1.0.zip`
- publish refreshed fork prerelease asset if external testers need a build newer than `codex-2.1.0-rc1`
- confirm zip contains:
  - `admin/`
  - `includes/`
  - `languages/`
  - `public/`
  - `divi-accessibility.php`
  - `readme.txt`
  - `uninstall.php`
- install the zip into a WordPress test site
- activate and deactivate without fatals
- confirm frontend response includes the Divi Accessibility payload
- confirm admin settings page loads

## Divi 4 Runtime Matrix

- skip link appears and works with keyboard
- focus outline appears only for keyboard navigation
- mobile menu opens and closes with keyboard
- mobile menu hides page content from screen readers while open
- navbar submenus remain visible/announced correctly for keyboard and screen-reader users
- slider arrows and dots have labels and keyboard support
- slider navigation dots have larger touch targets without obvious visual regression
- contact form success and error messages announce correctly
- contact form checkbox fields are keyboard operable
- module-level Accessibility Settings toggles still work

## Divi 5 Runtime Matrix

- frontend checks above still pass
- Visual Builder shows `Accessibility Settings`
- both toggles persist after save and reopen
- migrated D4 content preserves:
  - `hide_aria_element`
  - `show_for_screen_readers_only`
- navbar/submenu behavior is checked against the issue `#122` complaint pattern

## Reviewer Notes

- verify the package, not just the source checkout
- test with developer mode off and on
- include at least one page with menu search/cart, slider, and contact form modules
- upstream PR context: `#121`
- takeover/adoption package: `docs/takeover-adoption-package.md`
- AFK batch evidence: `docs/afk-batch-2026-04-24.md`
