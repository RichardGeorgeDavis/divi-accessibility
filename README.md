![divi-accessibility](https://cloud.githubusercontent.com/assets/6676674/26787287/72430f40-49d7-11e7-89ec-a5bf07eb0f97.png)

A WordPress plugin that improves Divi accessibility across Divi 4 and Divi 5
with WCAG-aligned fixes. While there are many strong accessibility plugins for
WordPress generally, this project focuses on issues found specifically in Divi
and its builder output.

## Current Status

This fork is maintained by Richard George Davis as the practical release path
while official access is unresolved. The original plugin was created by
CampusPress, and upstream PR
[#121](https://github.com/campuspress/divi-accessibility/pull/121) is now
closed as historical takeover/adoption context.

Current fork releases are published at
[RichardGeorgeDavis/divi-accessibility](https://github.com/RichardGeorgeDavis/divi-accessibility/releases).
The WordPress.org listing for `accessible-divi` is closed by author request, so
this fork should not be treated as an official WordPress.org continuation unless
CampusPress or WordPress.org grants ownership or committer access.

The plugin includes a native GitHub Releases updater for this maintained fork.
Sites must install `2.1.1` or later once; after that, future stable fork
releases with a packaged zip asset and matching `.zip.sha256` checksum asset
appear through WordPress' normal Plugins update screen.

## Accessibility Scope

Divi Accessibility applies targeted, WCAG-aligned improvements to Divi-generated
markup and behavior. It does not guarantee WCAG conformance for a whole website.
Final accessibility depends on theme configuration, page content, color contrast,
media alternatives, third-party plugins, custom CSS/JS, and editorial practice.

## License

Divi Accessibility is licensed under `GPL-2.0-or-later`. The repository keeps
the full GNU General Public License version 2 text in `LICENSE` for GitHub and
WordPress plugin compatibility.

## Community

+ Ask questions in
  [GitHub Discussions Q&A](https://github.com/RichardGeorgeDavis/divi-accessibility/discussions/categories/q-a)
+ Read the [license](LICENSE)
+ Review [contribution guidelines](CONTRIBUTING.md)
+ See [funding options](.github/FUNDING.yml)
+ Follow the [Code of Conduct](CODE_OF_CONDUCT.md)
+ Report vulnerabilities through the [security policy](SECURITY.md)
+ Use [support guidance](SUPPORT.md)
+ Browse the tracked [wiki landing page](docs/wiki.md)
+ Support the work through [PayPal](https://www.paypal.com/donate/?hosted_button_id=Z9ET7KXE4MMZS)

## Features

+ Divi 4 and Divi 5 compatibility, including builder-side module accessibility
  toggles and focused Divi 4 module ARIA fields
+ ARIA, labels, and keyboard fixes for core Divi navigation, search, slider,
  and contact form behaviors
+ Reduced motion support that respects user operating system/browser preferences
+ Mobile menu screen-reader isolation while the menu is open
+ Configurable skip links for content, navigation, and footer targets, plus
  focus outline and screen-reader-text fixes tuned for Divi markup
+ Plugin-owned compatibility styling for Divi 4 and Divi 5 without importing
  theme styles wholesale
+ Native GitHub Releases updater for packaged fork releases
+ Tota11y integration for admin-side review

## Module ARIA Fields

Divi 4 modules include focused Accessibility Settings for wrapper-level `role`,
`aria-label`, `aria-labelledby`, `aria-description`, `aria-describedby`, and
`aria-details` output. These fields migrate into the plugin's Divi 5
compatibility namespace and continue rendering on the frontend for migrated
content.

For new arbitrary attributes in Divi 5, use Divi's native Advanced > Attributes
panel. This plugin does not duplicate Divi 5's generic Custom Attributes UI.

## Skip Links

The skip link feature can output keyboard-visible links to navigation, content,
and footer landmarks. Only the content skip link is enabled by default for
backward compatibility; navigation and footer links can be enabled and pointed at
site-specific selectors from the plugin settings.

## Release 2.1.8

`2.1.8` is a focused post-`2.1.7` runtime fix release. It restores
mobile-menu Escape behavior when focus is inside the open mobile menu, returning
focus to the menu button after close, and it ignores stale cached updater release
metadata that lacks the checksum field required by current releases.

## Release 2.1.7

`2.1.7` hardens the maintained fork release path. Packaged releases now produce
a matching `.zip.sha256` checksum file, and the GitHub updater only accepts
stable releases that include both the exact versioned zip and checksum assets.
It also verifies the downloaded package before WordPress installs it, preserves
saved settings while merging new defaults, fixes packaged translation loading,
and includes small frontend/admin reliability fixes found during audit cleanup.

## Release 2.1.6

`2.1.6` follows up the Accessibility Helper and Image Helper release with
builder-preview parity and migration hardening. It keeps D4-to-D5 Image Helper
conversion mappings registered even when the feature is disabled, resolves Divi
5 builder image metadata from the configured media/source mode where available,
sanitizes builder-preview description HTML, and preserves the menu-specific
search label.

## Release 2.1.5

`2.1.5` ports the better Accessibility Helper behavior from Divi Assistant while
keeping this plugin's stronger existing implementations. It adds feature-gated
Image Helper support for Divi 5 Image modules, media-library image alt fallback
options for supported Divi image modules, safer labels for common Divi controls,
and fixes for search-control visibility, keyboard outlines, submenu state, and
D4-to-D5 Image Helper conversion output.

## Release 2.1.4

`2.1.4` fixes JavaScript-inserted skip links so they remain visually hidden until
focused even when page optimization removes unused CSS. It also prevents
duplicate skip links and duplicate hash-link focus handlers if the skip-link
script runs more than once.

## Release 2.1.3

`2.1.3` adds configurable navigation/content/footer skip links, focused module
ARIA guardrails and guidance, project accessibility testing docs, and pragmatic
CI/release metadata checks. It also keeps migrated Divi 4 module accessibility
attributes rendering through the Divi 5 compatibility namespace while avoiding a
generic Divi 5 Custom Attributes UI.

## Release 2.1.2

`2.1.2` fixes the skip navigation link so it stays visually hidden until focused
even when the broader screen-reader-text option is disabled. It also removes the
outdated admin note that implied the skip link depends on that separate option.

## Release 2.1.1

`2.1.1` adds the maintained fork's native GitHub Releases updater. This is the
bootstrap updater release: sites need to install `2.1.1` manually once, then
future stable fork releases can appear in WordPress' normal Plugins update screen
when the GitHub Release includes an exact packaged zip asset named like
`divi-accessibility-X.X.X.zip`. Current updater code also requires a matching
checksum asset named like `divi-accessibility-X.X.X.zip.sha256`.

## Release 2.1.0

This release line focuses on making Divi 5 a first-class supported target while
preserving Divi 4 compatibility. The branch now includes:

+ Divi 5 module-level `Accessibility Settings` with the existing two toggles
+ D4-to-D5 support for the legacy accessibility attrs on migrated content
+ Improved slider controls and dot target sizing
+ Improved accessible names for search and cart controls
+ Improved contact form announcement, invalid-state, and checkbox keyboard support
+ Navbar submenu and tabs state fixes found during packaged-plugin runtime verification
+ Packaged release fixes for translations, metadata, and npm lint coverage

## Last Recorded Runtime-Tested Integrations

The latest recorded full manual browser integration evidence is from the `2.1.0`
release line. No new full Divi 4 or Divi 5 browser runtime pass has been
recorded for `2.1.7` yet.

+ Divi Pixel `2.50.0` and `2.50.1`: alternate/mobile header hamburger behavior,
  menu open/close state, `aria-expanded` sync, and screen-reader isolation while
  the mobile menu is open
+ WooCommerce `10.7.0`: account/cart/shop page rendering and compatibility with
  Divi Accessibility frontend payloads where the normal theme footer scripts are
  printed

These checks are compatibility evidence, not a blanket certification for every
module or site configuration. WooCommerce store-only/coming-soon responses that
do not print normal footer scripts cannot run footer-enqueued Divi Accessibility
JavaScript on those responses.


## Development

The working js/css snippets are, by default, included minified. They can be
forcefully included in their full expanded state by enabling the developer mode
option in plugin settings. They also respect the WP core `SCRIPT_DEBUG` define
value.

To check js/css snippets for any errors, run the dedicated `npm run lint` script.

To build the minified versions of the js/css snippets, run `npm run build` script.

While working on snippets, it may be beneficial to have them automatically
re-built on file change. This is what the `npm run watch` script does.

To package an intermediate (throwaway) plugin zip archive for testing, use the
`npm run package` script. The zip and `.sha256` checksum file are written to
`packaged/`.

To build a releaseable package, use
`DA11Y_RELEASE_VERSION=X.X.X DA11Y_ASSUME_YES=true npm run release`. This will
normalize version numbers across the plugin bootstrap, package metadata, readme
stable tag, and POT metadata, then lint, regenerate the translation catalog,
rebuild the assets, and produce a versioned zip archive.

The release version can either be supplied via `DA11Y_RELEASE_VERSION=x.x.x`, or
it will be inferred from the version-bearing files already in the repo. If the
version number is inferred, the highest existing version is used.

If the final resolved release version is different from the repo metadata, the
prerelease script can update those files automatically. Use `-y` to skip prompts.

GitHub release updates require the packaged zip asset, not GitHub's generated
source archive. For each stable release, attach
`packaged/divi-accessibility-X.X.X.zip` and
`packaged/divi-accessibility-X.X.X.zip.sha256` to the GitHub Release with those
exact asset names; the plugin updater will ignore drafts, prereleases, and
releases that do not include both matching assets.


## Resources

+ [Web Content Accessibility Guidelines (WCAG) 2.2](https://www.w3.org/TR/WCAG22/)
+ [WAI-ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
+ [Tota11y](https://khan.github.io/tota11y/)
+ [Divi](https://www.elegantthemes.com/gallery/divi/)

## Credit

Originally created by [CampusPress](https://campuspress.com). This maintained
fork is currently maintained by
[Richard George Davis](https://github.com/RichardGeorgeDavis) unless official
project ownership or committer access is granted. Plugin icon based off of
[The Accessible Icon Project](http://accessibleicon.org/).
