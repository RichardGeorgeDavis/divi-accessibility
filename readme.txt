=== Divi Accessibility ===
Contributors: RichardGeorgeDavis, campuspress, JoeFusco, alexstine, vebailovity
Tags: divi, accessibility, accessible, navigation, wcag, a11y, section508, focus, labels, aria
Requires at least: 6.0
Tested up to: 6.9.4
Stable tag: 2.1.8
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Improve Divi accessibility across Divi 4 and Divi 5 with WCAG-aligned fixes.

== Description ==

A WordPress plugin that improves Divi accessibility across Divi 4 and Divi 5
with WCAG-aligned fixes. While there are many great plugins dealing with
improving WordPress theme accessibility, this was developed for issues
specifically found within Divi.

* Adds ARIA, labels, and keyboard improvements across Divi 4 and Divi 5
* Supports Divi 5 builder-side Accessibility Settings while preserving Divi 4 behavior
* Adds focused Divi 4 module ARIA fields for wrapper-level role, labels,
  descriptions, and details, with Divi 5 migrated-content render parity
* Improves slider controls, search/cart naming, mobile menu behavior, and contact form feedback
* Adds reduced motion support and version-scoped plugin-owned compatibility styling
* Fixes Divi screen-reader-text behavior, configurable skip links, focus
  outlines, duplicate menu IDs, and icon handling
* Checks this maintained fork's stable GitHub Releases for checksum-verified
  packaged plugin updates through WordPress' normal Plugins update screen
* Includes Tota11y integration for admin-side review

= Current Status =

Richard George Davis maintains this fork while official access is unresolved.
The historical upstream plugin was created by CampusPress, and the upstream
release-candidate PR is closed as takeover/adoption context.

This fork should not be treated as an official WordPress.org continuation unless
upstream or WordPress.org grants ownership or committer access.

Sites must install version 2.1.1 or later once. After that, future stable fork
releases are checked through WordPress' normal Plugins update screen when the
GitHub Release includes a packaged zip asset named like
divi-accessibility-2.2.0.zip and a matching
divi-accessibility-2.2.0.zip.sha256 checksum asset.

= Accessibility Scope =

Divi Accessibility applies targeted, WCAG-aligned improvements to Divi-generated
markup and behavior. It does not guarantee WCAG conformance for a whole website.
Final accessibility depends on theme configuration, page content, color contrast,
media alternatives, third-party plugins, custom CSS/JS, and editorial practice.

= Module ARIA Fields =

Divi 4 modules include focused Accessibility Settings for wrapper-level role,
aria-label, aria-labelledby, aria-description, aria-describedby, and aria-details
output. These fields migrate into the plugin's Divi 5 compatibility namespace
and continue rendering on the frontend for migrated content.

For new arbitrary attributes in Divi 5, use Divi's native Advanced > Attributes
panel. This plugin does not duplicate Divi 5's generic Custom Attributes UI.

= Skip Links =

The skip link feature can output keyboard-visible links to navigation, content,
and footer landmarks. Only the content skip link is enabled by default for
backward compatibility; navigation and footer links can be enabled and pointed at
site-specific selectors from the plugin settings.

= Community =

Ask questions in GitHub Discussions Q&A:
[https://github.com/RichardGeorgeDavis/divi-accessibility/discussions/categories/q-a](https://github.com/RichardGeorgeDavis/divi-accessibility/discussions/categories/q-a)

Project files:

* LICENSE
* CONTRIBUTING.md
* CODE_OF_CONDUCT.md
* SECURITY.md
* SUPPORT.md
* FUNDING.yml
* docs/wiki.md

Support the work:
[https://www.paypal.com/donate/?hosted_button_id=Z9ET7KXE4MMZS](https://www.paypal.com/donate/?hosted_button_id=Z9ET7KXE4MMZS)

= Last Recorded Runtime-Tested Integrations =

The latest recorded focused browser runtime evidence is from version 2.1.8, with
broader Divi 4 and Divi 5 module-matrix evidence recorded for version 2.1.7.
See docs/module-support-matrix.md and docs/afk-batch-2026-05-10.md in the
GitHub repository for exact WordPress, PHP, Divi, browser, and package details.

* Divi Pixel 2.50.0 and 2.50.1: alternate/mobile header hamburger behavior,
  menu open/close state, aria-expanded sync, and screen-reader isolation while
  the mobile menu is open.
* WooCommerce 10.7.0: account/cart/shop page rendering and compatibility with
  Divi Accessibility frontend payloads where the normal theme footer scripts are
  printed.

These checks are compatibility evidence, not a blanket certification for every
module or site configuration. WooCommerce store-only/coming-soon responses that
do not print normal footer scripts cannot run footer-enqueued Divi Accessibility
JavaScript on those responses.

= Contribute on GitHub =

Fork releases and active maintenance:
[https://github.com/RichardGeorgeDavis/divi-accessibility/](https://github.com/RichardGeorgeDavis/divi-accessibility/)

Historical upstream PR:
[https://github.com/campuspress/divi-accessibility/pull/121](https://github.com/campuspress/divi-accessibility/pull/121)

= Credit =

Maintained by Richard George Davis. Original project by
[CampusPress](https://campuspress.com). Plugin icon based off of
[The Accessible Icon Project](http://accessibleicon.org/).


== Installation ==

1. Upload 'divi-accessibility' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the new menu item "Accessibility" under the Divi menu for settings
4. Install version 2.1.1 or later once to enable future maintained-fork updates
   through the normal WordPress Plugins update screen

== Frequently Asked Questions ==

= Does this work with Divi 5? =

Yes. Version 2.1.0 added foundational Divi 5 compatibility work while keeping
Divi 4 support in place, and later maintained-fork releases preserve that
compatibility path.

= Does this still support Divi 4? =

Yes. The plugin keeps the legacy Divi 4 hooks and frontend fixes, and adds
compatibility layers only where Divi 5 requires a separate path.

= How do GitHub release updates work? =

Version 2.1.1 is the bootstrap updater release. After a site has 2.1.1 or later
installed, the plugin checks the latest stable release at
github.com/RichardGeorgeDavis/divi-accessibility and exposes newer packaged
releases through WordPress' normal plugin updater. Current updater code ignores
drafts, prereleases, GitHub source archives, and releases without both a
packaged divi-accessibility-*.zip asset and matching
divi-accessibility-*.zip.sha256 checksum asset.


== Screenshots ==

1. Divi Accessibility settings page


== Changelog ==

= 2.1.8 =
* Fixed mobile menu Escape handling so menus close and focus returns to the
  menu button when Escape is pressed from a focused mobile menu link.
* Ignored stale cached updater release data that predates required checksum
  assets, preventing missing-checksum warnings after upgrading from older
  cached release metadata.

= 2.1.7 =
* Required maintained-fork GitHub releases to include both the exact packaged
  zip asset and a matching .zip.sha256 checksum asset.
* Verified update package downloads against the published SHA-256 checksum
  before WordPress installs them.
* Added checksum generation to the release package script and release metadata
  checks.
* Preserved existing plugin settings while merging new defaults during
  activation and runtime loading.
* Fixed packaged translation loading and tightened frontend/admin reliability
  around inline styles, hash-link focus, search focus handlers, mobile menu
  keyboard activation, and Divi 5 builder metadata access.

= 2.1.6 =
* Kept D4-to-D5 Image Helper conversion mappings registered even when the Image
  Helper module fields option is disabled.
* Improved Divi 5 builder preview parity for Image Helper media metadata source
  modes.
* Sanitized Image Helper description HTML in the Divi 5 builder preview.
* Preserved the menu-specific search icon label when broader ARIA support runs.

= 2.1.5 =
* Added feature-gated Image Helper support for Divi 5 Image modules, including
  aspect-ratio controls and optional visible image title, caption, and
  description metadata.
* Added media-library image alt fallback options for supported Divi image
  modules while preserving authored alt text unless override mode is selected.
* Added optional image title-tooltip removal and menu-specific underline
  exclusions.
* Improved accessible labels and keyboard behavior for menu/search, social,
  read-more, video, audio, image-link, new-tab, and back-to-top controls.
* Fixed search controls being hidden from assistive technology and tightened
  D4-to-D5 Image Helper conversion output.

= 2.1.4 =
* Fixed JavaScript-inserted skip links so their hidden-until-focused styling is
  preserved even when page optimization removes unused CSS.
* Prevented duplicate skip links and duplicate hash-link focus handlers if the
  skip-link script runs more than once.

= 2.1.3 =
* Added configurable skip links for navigation, content, and footer targets while
  preserving the existing content-only default behavior.
* Added focused module ARIA fields for Divi 4 with Divi 5 migrated-content render parity.
* Added guardrails and admin guidance for plugin-owned module ARIA fields.
* Added module support matrix and manual accessibility checklist documentation.
* Added pragmatic CI and non-mutating release metadata validation.

= 2.1.2 =
* Fixed skip navigation link styling so it remains visually hidden until focused
  even when the broader screen reader text option is disabled.
* Removed outdated admin copy that said the skip navigation link requires the
  screen reader text option.

= 2.1.1 =
* Added native GitHub Releases update integration for future packaged fork releases.
* Limited updater packages to exact matching packaged release zip assets.
* Avoided sending site URLs in GitHub updater request headers.

= 2.1.0 =
* Added Divi 5 module-level Accessibility Settings support while preserving Divi 4 compatibility.
* Added frontend support for migrated D4-to-D5 module accessibility attrs.
* Added mobile menu screen-reader isolation while the menu is open.
* Added reduced motion support for users who prefer less animation.
* Improved slider labels, keyboard support, and navigation dot target sizing.
* Improved contact form success/error announcements and validation state syncing
  after async rerenders.
* Improved contact form checkbox keyboard accessibility.
* Improved accessible names for default header and menu search/cart controls.
* Improved compatibility with Divi Pixel mobile header/hamburger state changes.
* Fixed navbar submenu focus state so visible keyboard-opened submenus also report expanded state.
* Fixed tabs keyboard navigation so inactive panels are hidden from assistive technologies.
* Added fallback handling for Divi templates that use #et-main-area without #main-content.
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
