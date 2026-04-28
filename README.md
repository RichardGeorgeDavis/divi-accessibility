![divi-accessibility](https://cloud.githubusercontent.com/assets/6676674/26787287/72430f40-49d7-11e7-89ec-a5bf07eb0f97.png)

A WordPress plugin that improves Divi accessibility across Divi 4 and Divi 5 with WCAG-aligned fixes. While there are many strong accessibility plugins for WordPress generally, this project focuses on issues found specifically in Divi and its builder output.

## Current Status

This fork is maintained by Richard George Davis as the practical release path while official access is unresolved. The original plugin was created by CampusPress, and upstream PR [#121](https://github.com/campuspress/divi-accessibility/pull/121) remains the canonical takeover-compatible patch set for review by the original maintainers.

Current fork releases are published at [RichardGeorgeDavis/divi-accessibility](https://github.com/RichardGeorgeDavis/divi-accessibility/releases). The WordPress.org listing for `accessible-divi` is closed by author request, so this fork should not be treated as an official WordPress.org continuation unless CampusPress or WordPress.org grants ownership or committer access.

The plugin includes a native GitHub Releases updater for this maintained fork. Sites must install `2.1.1` or later once; after that, future stable fork releases with a packaged zip asset appear through WordPress' normal Plugins update screen.

## Community

+ Ask questions in [GitHub Discussions Q&A](https://github.com/RichardGeorgeDavis/divi-accessibility/discussions/categories/q-a)
+ Read the [license](LICENSE)
+ Review [contribution guidelines](CONTRIBUTING.md)
+ See [funding options](.github/FUNDING.yml)
+ Follow the [Code of Conduct](CODE_OF_CONDUCT.md)
+ Report vulnerabilities through the [security policy](SECURITY.md)
+ Use [support guidance](SUPPORT.md)
+ Browse the tracked [wiki landing page](docs/wiki.md)
+ Support the work through [PayPal](https://www.paypal.com/donate/?hosted_button_id=Z9ET7KXE4MMZS)

## Features

+ Divi 4 and Divi 5 compatibility, including builder-side module accessibility toggles
+ ARIA, labels, and keyboard fixes for core Divi navigation, search, slider, and contact form behaviors
+ Reduced motion support that respects user operating system/browser preferences
+ Mobile menu screen-reader isolation while the menu is open
+ Skip link, focus outline, and screen-reader-text fixes tuned for Divi markup
+ Plugin-owned compatibility styling for Divi 4 and Divi 5 without importing theme styles wholesale
+ Native GitHub Releases updater for packaged fork releases
+ Tota11y integration for admin-side review

## Release 2.1.2

`2.1.2` fixes the skip navigation link so it stays visually hidden until focused even when the broader screen-reader-text option is disabled. It also removes the outdated admin note that implied the skip link depends on that separate option.

## Release 2.1.1

`2.1.1` adds the maintained fork's native GitHub Releases updater. This is the bootstrap updater release: sites need to install `2.1.1` manually once, then future stable fork releases can appear in WordPress' normal Plugins update screen when the GitHub Release includes an exact packaged zip asset named like `divi-accessibility-2.1.2.zip`.

## Release 2.1.0

This release line focuses on making Divi 5 a first-class supported target while preserving Divi 4 compatibility. The branch now includes:

+ Divi 5 module-level `Accessibility Settings` with the existing two toggles
+ D4-to-D5 support for the legacy accessibility attrs on migrated content
+ Improved slider controls and dot target sizing
+ Improved accessible names for search and cart controls
+ Improved contact form announcement, invalid-state, and checkbox keyboard support
+ Navbar submenu and tabs state fixes found during packaged-plugin runtime verification
+ Packaged release fixes for translations, metadata, and npm lint coverage

## Runtime-Tested Integrations

The `2.1.0` release line has been browser-tested against these active third-party plugins in local Divi 5 sites:

+ Divi Pixel `2.50.0` and `2.50.1`: alternate/mobile header hamburger behavior, menu open/close state, `aria-expanded` sync, and screen-reader isolation while the mobile menu is open
+ WooCommerce `10.7.0`: account/cart/shop page rendering and compatibility with Divi Accessibility frontend payloads where the normal theme footer scripts are printed

These checks are compatibility evidence, not a blanket certification for every module or site configuration. WooCommerce store-only/coming-soon responses that do not print normal footer scripts cannot run footer-enqueued Divi Accessibility JavaScript on those responses.


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

GitHub release updates require the packaged zip asset, not GitHub's generated source archive. For each stable release, attach `packaged/divi-accessibility-X.X.X.zip` to the GitHub Release with the asset name `divi-accessibility-X.X.X.zip`; the plugin updater will ignore drafts, prereleases, and releases that do not include a matching packaged zip.


## Resources

+ [Web Content Accessibility Guidelines (WCAG) 2.2](https://www.w3.org/TR/WCAG22/)
+ [WAI-ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
+ [Tota11y](https://khan.github.io/tota11y/)
+ [Divi](https://www.elegantthemes.com/gallery/divi/)

## Credit

Originally created by [CampusPress](https://campuspress.com). This maintained fork is currently maintained by [Richard George Davis](https://github.com/RichardGeorgeDavis) unless official project ownership or committer access is granted. Plugin icon based off of [The Accessible Icon Project](http://accessibleicon.org/).
