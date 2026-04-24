![divi-accessibility](https://cloud.githubusercontent.com/assets/6676674/26787287/72430f40-49d7-11e7-89ec-a5bf07eb0f97.png)

[![wordpress.org version badge](https://img.shields.io/wordpress/plugin/v/accessible-divi.svg)](https://wordpress.org/plugins/accessible-divi/) [![wordpress.org download count badge](https://img.shields.io/wordpress/plugin/dt/accessible-divi.svg)](https://wordpress.org/plugins/accessible-divi/)

A WordPress plugin that improves Divi accessibility across Divi 4 and Divi 5 with WCAG-aligned fixes. While there are many strong accessibility plugins for WordPress generally, this project focuses on issues found specifically in Divi and its builder output.

## Maintenance Status

This fork is maintained by Richard George Davis as the practical release path while official access is unresolved. The original plugin was created by CampusPress, and upstream PR [#121](https://github.com/campuspress/divi-accessibility/pull/121) remains the canonical takeover-compatible patch set for review by the original maintainers.

Current fork releases are published at [RichardGeorgeDavis/divi-accessibility](https://github.com/RichardGeorgeDavis/divi-accessibility/releases). The WordPress.org listing for `accessible-divi` is closed by author request, so this fork should not be treated as an official WordPress.org continuation unless CampusPress or WordPress.org grants ownership or committer access.

## Features

+ Divi 4 and Divi 5 compatibility, including builder-side module accessibility toggles
+ ARIA, labels, and keyboard fixes for core Divi navigation, search, slider, and contact form behaviors
+ Reduced motion support that respects user operating system/browser preferences
+ Mobile menu screen-reader isolation while the menu is open
+ Skip link, focus outline, and screen-reader-text fixes tuned for Divi markup
+ Plugin-owned compatibility styling for Divi 4 and Divi 5 without importing theme styles wholesale
+ Tota11y integration for admin-side review

## Release 2.1.0

This release line focuses on making Divi 5 a first-class supported target while preserving Divi 4 compatibility. The branch now includes:

+ Divi 5 module-level `Accessibility Settings` with the existing two toggles
+ D4-to-D5 support for the legacy accessibility attrs on migrated content
+ Improved slider controls and dot target sizing
+ Improved accessible names for search and cart controls
+ Improved contact form announcement, invalid-state, and checkbox keyboard support
+ Navbar submenu and tabs state fixes found during packaged-plugin runtime verification
+ Packaged release fixes for translations, metadata, and npm lint coverage


Development
-----------

The working js/css snippets are, by default, included minified. They can be forcefully included in their full expanded state by enabling the developer mode option in plugin settings. They also respect the WP core `SCRIPT_DEBUG` define value.

To check js/css snippets for any errors, run the dedicated `npm run lint` script.

To build the minified versions of the js/css snippets, run `npm run build` script.

While working on snippets, it may be beneficial to have them automatically re-built on file change. This is what the `npm run watch` script does.

To package an intermediate (throwaway) plugin zip archive for testing, use the `npm run package` script. The zip is written to `packaged/`.

To build a releaseable package, use `DA11Y_RELEASE_VERSION=X.X.X DA11Y_ASSUME_YES=true npm run release`. This will normalize version numbers across the plugin bootstrap, package metadata, readme stable tag, and POT metadata, then lint, regenerate the translation catalog, rebuild the assets, and produce a versioned zip archive.

The release version can either be supplied via `DA11Y_RELEASE_VERSION=x.x.x`, or it will be inferred from the version-bearing files already in the repo. If the version number is inferred, the highest existing version is used.

If the final resolved release version is different from the repo metadata, the prerelease script can update those files automatically. Use `-y` to skip prompts.


## Resources

+ [Web Content Accessibility Guidelines (WCAG) 2.2](https://www.w3.org/TR/WCAG22/)
+ [WAI-ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
+ [Tota11y](https://khan.github.io/tota11y/)
+ [Divi](https://www.elegantthemes.com/gallery/divi/)

## Support

If you would like to make a donation, we encourage you to consider donating to [Knowbility](https://knowbility.org/) and help support their mission to provide access to technology for people with disabilities.

## Credit

Originally created by [CampusPress](https://campuspress.com). This maintained fork is currently maintained by [Richard George Davis](https://github.com/RichardGeorgeDavis) unless official project ownership or committer access is granted. Plugin icon based off of [The Accessible Icon Project](http://accessibleicon.org/).
