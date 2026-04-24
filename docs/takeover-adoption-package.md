# Divi Accessibility Takeover / Adoption Package

## Current Status

- Date checked: 2026-04-24
- Upstream repository: <https://github.com/campuspress/divi-accessibility>
- Upstream release-candidate PR: <https://github.com/campuspress/divi-accessibility/pull/121>
- WordPress.org plugin page: <https://wordpress.org/plugins/accessible-divi/>
- CampusPress public contact page: <https://campuspress.com/contact-us/>
- CampusPress public contact email: `contact@campuspress.com`
- Current fork prerelease: <https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/codex-2.1.0-rc4>
- Current fork package SHA-256: `2880f061195bec6cd15dc4873ad977443e6aa3b8c6bd0c310a1c12557aef6253`
- WordPress.org status: closed as of 2020-05-12, unavailable for download, closure reason `Author Request`
- Current strategy: dual track
  - pursue official adoption or maintainer access
  - keep the fork moving as the practical maintained release path unless official access is granted

## Evidence Of Maintenance Need

- `#121` prepares a `2.1.0` compatibility and accessibility maintenance release.
- `#90` reports repeated PHP warnings from an undefined `$tota11y` path; the fix is included in `#121`.
- `#122` reports active user impact around Divi navbar submenu visibility and announcement behavior; one related Divi 5 submenu focus state mismatch was reproduced and fixed in the branch.
- WordPress.org reviews and GitHub issues show long-standing demand for maintained Divi accessibility fixes.
- The WordPress.org listing has not been available for download since 2020-05-12.

## Current Upstream Activity

- `#121` is open, draft, mergeable, and clean.
- There are no reviews, no assignees, and no requested reviewers on `#121`.
- The maintainer follow-up comment was posted on 2026-04-16:
  - <https://github.com/campuspress/divi-accessibility/pull/121#issuecomment-4259477492>
- As of 2026-04-24, there has been no maintainer response to that follow-up.
- `#122` was opened on 2026-04-14 and has no maintainer response.

## Official Adoption Process Notes

The WordPress.org Plugin Handbook says there are two adoption paths:

- ask the original developer directly; if they agree, they can add/transfer access
- ask the Plugin Review Team to assist if the original developer cannot be reached or does not reply

The handbook also says an adoption request should include:

- evidence that reasonable contact attempts were made
- updated code attached as a zip or linked publicly
- an explanation of the intended maintenance work
- readiness for a normal plugin security/guideline review

Important constraint:

- Because the plugin was closed by `Author Request`, WordPress.org may deny takeover or require explicit author approval. If that happens, maintain a renamed fork instead of claiming official continuity.

## Contact Attempts Log

| Date | Channel | Target | Outcome |
| --- | --- | --- | --- |
| 2026-04-09 | GitHub PR | `#121` | Release candidate opened and testing help requested. |
| 2026-04-09 | GitHub issue | `#90` | Fix linked back to `#121`; issue could not be closed without maintainer permission. |
| 2026-04-16 | GitHub PR | `#121` | Maintainer follow-up posted with concrete review/merge asks. |
| 2026-04-24 | GitHub status check | `#121`, `#122` | No maintainer response found. |
| 2026-04-24 | GitHub PR | `#121` | RC2 package/smoke verification progress posted with remaining runtime gates. |
| 2026-04-24 | LocalWP/browser verification | `#122` | Reproduced and fixed Divi 5 submenu focus state mismatch; rebuilt package as RC3 candidate. |
| 2026-04-24 | LocalWP/browser verification | `divi-draft` module page | Reproduced and fixed tabs panel `aria-hidden` mismatch; rebuilt package as RC4 candidate. |
| TBD | Direct contact | `contact@campuspress.com` / CampusPress contact page | Request GitHub maintainer access or WordPress.org transfer. |
| TBD | Email | `plugins@wordpress.org` | Submit adoption request if direct maintainer contact does not resolve access. |

## CampusPress / Maintainer Contact Template

Subject:

```text
Request to help maintain Divi Accessibility
```

Body:

```text
Hello,

I have been working on a maintained Divi Accessibility release candidate at:
https://github.com/campuspress/divi-accessibility/pull/121

The PR prepares a 2.1.0 compatibility and accessibility maintenance release with Divi 4 and Divi 5 support, packaging fixes, and a fix for issue #90. A newer user issue, #122, also shows there is still active demand for maintained Divi accessibility support.

The WordPress.org listing for accessible-divi is currently closed by author request, so I want to handle this transparently and with the original maintainers' preference respected.

Would CampusPress be willing to do one of the following?

- add me as a GitHub maintainer/committer so I can help review and ship the existing PRs
- transfer or add WordPress.org plugin access so the project can receive maintained releases again
- confirm that you prefer the project remain closed, in which case I will continue only as a clearly renamed community fork

I can provide the release zip, verification notes, and a maintenance plan if useful.

Thanks,
Richard George Davis
```

## WordPress.org Adoption Request Draft

Subject:

```text
Adoption request for accessible-divi
```

Body:

```text
Hello Plugin Review Team,

I would like to request guidance on adopting or maintaining the closed WordPress.org plugin `accessible-divi`:
https://wordpress.org/plugins/accessible-divi/

I understand the listing is closed as of 2020-05-12 with the reason `Author Request`, so I also understand this request may require original author approval or may be denied. If takeover is not appropriate, I will maintain a renamed fork instead of claiming official continuity.

Reason for the request:

- The plugin addresses Divi-specific accessibility gaps.
- Users are still reporting active accessibility problems upstream.
- The GitHub repository has an open release-candidate PR for a 2.1.0 maintenance release:
  https://github.com/campuspress/divi-accessibility/pull/121
- The branch includes a fix for repeated PHP warnings reported in issue #90:
  https://github.com/campuspress/divi-accessibility/issues/90
- A newer issue #122 reports current navbar/submenu accessibility impact:
  https://github.com/campuspress/divi-accessibility/issues/122

Contact attempts:

- 2026-04-09: Opened and documented the release-candidate PR.
- 2026-04-09: Linked the issue #90 fix to the release-candidate PR.
- 2026-04-16: Posted a maintainer follow-up on PR #121 with concrete review/merge asks.
- 2026-04-24: Rechecked PR and issue activity; no maintainer response found.
- 2026-04-24: Posted RC2 package/smoke verification progress:
  https://github.com/campuspress/divi-accessibility/pull/121#issuecomment-4311364696
- 2026-04-24: Reproduced and fixed one related submenu state issue from #122 in the refreshed branch/package.
- 2026-04-24: Reproduced and fixed one tabs panel state issue on the Divi draft module page in the refreshed branch/package.
- Direct maintainer contact attempt: [fill in date/channel/result before sending]

Updated code:

- Public repository/PR: https://github.com/campuspress/divi-accessibility/pull/121
- Fork release/test build: https://github.com/RichardGeorgeDavis/divi-accessibility/releases/tag/codex-2.1.0-rc4
- Final runtime verification notes: [insert final verification notes URL or summary]

I am prepared to address any Plugin Review Team findings and update the code to current WordPress.org plugin guidelines before any official release.

Thanks,
Richard George Davis
```

## April 30 Final PR Comment Template

Use this only after runtime verification is complete and only if there has still been no maintainer response.

```text
Final release-candidate follow-up for `#121`.

Runtime verification is now complete:

- packaged plugin install/activate: [pass/fail + environment]
- Divi 4 frontend smoke test: [pass/fail + notes]
- Divi 5 frontend smoke test: [pass/fail + notes]
- Divi 5 save/reopen persistence for the two accessibility toggles: [pass/fail + notes]
- migrated D4-to-D5 accessibility attrs: [pass/fail + notes]
- navbar/submenu follow-up related to #122: [pass/fail + notes]

This PR is ready for maintainer review once any failed checks above are resolved. I am also willing to help maintain the project if CampusPress wants assistance with GitHub triage, WordPress.org release access, or ongoing compatibility work.

Concrete asks:

- review `#121` for merge
- close `#90` if the included `tota11y` fix is acceptable
- confirm whether the older open PRs should be closed as superseded, merged separately, or kept for follow-up
```

## Fork Maintenance Rules

- Keep `#121` as the canonical upstream patch set while upstream remains open.
- Do not present the fork as the official WordPress.org continuation unless access is granted.
- If WordPress.org adoption is denied, rename/rebrand the fork before submitting it as a separate plugin.
- Keep original authors credited in code and documentation.
- Add new ownership/maintenance notes only when submitting for official review or publishing a forked release.
