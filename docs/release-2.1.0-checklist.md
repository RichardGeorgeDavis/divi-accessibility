# Release 2.1.0 Checklist

## Current Verification Status

- Manual visual pass completed:
  - frontend tabs are working
  - Divi 5 Visual Builder modules show `Accessibility Settings`
- Still pending:
  - packaged-plugin install/activate verification
  - persistence checks after save/reopen
  - broader module-type coverage across Divi 4, Divi 5, and migrated D4-to-D5 content

## Static Checks

- `npm run lint`
- `npm run build`
- `npm run i18n`
- `php -l` on touched PHP files
- release/package dry run
- zip content inspection

## Package Checks

- build `packaged/divi-accessibility-2.1.0.zip`
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
- confirm admin settings page loads

## Divi 4 Runtime Matrix

- skip link appears and works with keyboard
- focus outline appears only for keyboard navigation
- mobile menu opens and closes with keyboard
- mobile menu hides page content from screen readers while open
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

## Reviewer Notes

- verify the package, not just the source checkout
- test with developer mode off and on
- include at least one page with menu search/cart, slider, and contact form modules
