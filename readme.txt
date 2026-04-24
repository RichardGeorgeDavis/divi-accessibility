=== Divi Accessibility ===
Contributors: campuspress, JoeFusco, alexstine, vebailovity
Tags: divi, accessibility, accessible, navigation, wcag, a11y, section508, focus, labels, aria
Requires at least: 6.0
Tested up to: 6.9.4
Stable tag: 2.1.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Improve Divi accessibility across Divi 4 and Divi 5 with WCAG-aligned fixes.

== Description ==

A WordPress plugin that improves Divi accessibility across Divi 4 and Divi 5 with WCAG-aligned fixes. While there are many great plugins dealing with improving WordPress theme accessibility, this was developed for issues specifically found within Divi.

* Adds ARIA, labels, and keyboard improvements across Divi 4 and Divi 5
* Supports Divi 5 builder-side Accessibility Settings while preserving Divi 4 behavior
* Improves slider controls, search/cart naming, mobile menu behavior, and contact form feedback
* Adds reduced motion support and version-scoped plugin-owned compatibility styling
* Fixes Divi screen-reader-text behavior, skip links, focus outlines, duplicate menu IDs, and icon handling
* Includes Tota11y integration for admin-side review

= Maintenance Status =

This fork is maintained by Richard George Davis while official access is unresolved. The original plugin was created by CampusPress, and the upstream release-candidate PR remains available for original-maintainer review.

This fork should not be treated as an official WordPress.org continuation unless CampusPress or WordPress.org grants ownership or committer access.

= Contribute on GitHub =

Fork releases and active maintenance:
[https://github.com/RichardGeorgeDavis/divi-accessibility/](https://github.com/RichardGeorgeDavis/divi-accessibility/)

Canonical upstream PR for maintainer review:
[https://github.com/campuspress/divi-accessibility/pull/121](https://github.com/campuspress/divi-accessibility/pull/121)

= Support =

If you would like to make a donation, we encourage you to consider donating to [Knowbility](https://knowbility.org/) and help support their mission to provide access to technology for people with disabilities.

= Credit =

Originally created by [CampusPress](https://campuspress.com). This maintained fork is currently maintained by Richard George Davis unless official project ownership or committer access is granted. Plugin icon based off of [The Accessible Icon Project](http://accessibleicon.org/).


== Installation ==

1. Upload 'divi-accessibility' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the new menu item "Accessibility" under the Divi menu for settings

== Frequently Asked Questions ==

= Does this work with Divi 5? =

Yes. Version 2.1.0 adds Divi 5 compatibility work while keeping Divi 4 support in place.

= Does this still support Divi 4? =

Yes. The plugin keeps the legacy Divi 4 hooks and frontend fixes, and adds compatibility layers only where Divi 5 requires a separate path.


== Screenshots ==

1. Divi Accessibility settings page


== Changelog ==

= 2.1.0 =
* Added Divi 5 module-level Accessibility Settings support while preserving Divi 4 compatibility.
* Added frontend support for migrated D4-to-D5 module accessibility attrs.
* Added mobile menu screen-reader isolation while the menu is open.
* Added reduced motion support for users who prefer less animation.
* Improved slider labels, keyboard support, and navigation dot target sizing.
* Improved contact form success/error announcements and validation state syncing after async rerenders.
* Improved contact form checkbox keyboard accessibility.
* Improved accessible names for default header and menu search/cart controls.
* Fixed navbar submenu focus state so visible keyboard-opened submenus also report expanded state.
* Fixed tabs keyboard navigation so inactive panels are hidden from assistive technologies.
* Added a minimal Divi 4/5 compatibility styling layer owned by the plugin.
* Fixed npm lint coverage, release metadata syncing, and packaged translation files.

= 2.0.5 =
* Added support for escape button in submenu.
* Added missing aria attributes to Accordion & Toggle (thanks @muiradams).
* Improvements for removal of focus class (thanks @kanterjoe).
* Improvements for adding role="link".

= 2.0.4 =
* Improvements for mobile menu opening and closing with keyboard.

= 2.0.3 =
* Fix mobile menu bugs.

= 2.0.2 =
* Added option to underline all links in Divi under #et-main-area.
* Added option to remove the underline from title and buttons in Divi.
* Added aria-haspopup="true" to submenus.
* All links now have role="link".
* All buttons, clickable icon now have role="button".
* The "g-recaptcha-response" is now accessible.

= 2.0.1 =
* Improvements for mobile menu opening and closing with keyboard.
* Admin screen improvements.

= 2.0.0 =
* Refactor inline styles and scripts to work with a packaging system.
* Add default aria-label to mobile menu.
* Fix back to top link default styles.
* Fix missing label on search form.

= 1.2.6 =
* Social links now have text, thanks to maco.
* Fix sanitization across the plugin.
* Fix default aria-expanded state on closed mobile menu.

= 1.2.5 =
* Update WordPress compatibility for 5.2.3.
* Fix undefined variable.
* Add main role to main content.
* Add option to enable mobile menu Aria enhancements.

= 1.2.4 =
* Fix keyboard navigation with submenus.
* Fix submenu highlight on mouse hover.
* Fix CSS warnings.

= 1.2.3 =
* Submenu item highlighting when mouse moves over links.

= 1.2.2 =
* Landmark refactoring for navigation.
* Add better support for submenus.

= 1.2.1 =
* Add better aria attribute support to navigation menus, comment forms, etc.
* CSS fixes.

= 1.2 =
* Add option to remove id attribute from list items in navigation menus

= 1.1 =
* Add option to hide decorative icons from screen readers
* Add hidden submit button to search
* Add alert role to success/error form message
* Increase color contrast of skiplink to meet WCAG AAA
* Fix contact module form not validating properly when using captcha
* Fix error with label not being added to search form
* Prevent spacebar from scrolling page when toggles have focus
* Remove up and down keys from changing tabs

= 1.0.4 =
* Fix contact module form not validating properly when using captcha

= 1.0.3 =
* Add missing quote in viewport tag causing issues in head

= 1.0.2 =
* Fix Divi viewport meta tag to make theme more accessibile

= 1.0.1 =
* Improve ARIA for Tab module

= 1.0.0 =
* Initial Release
