# Branch Cleanup After 2.1.0

Prepared: 2026-04-24

## Historical Release Branches

- Keep `master` as the maintained-fork release branch.
- `codex/divi4-divi5-style-compat` is historical upstream PR `#121` context.
- Do not merge old feature branches into `master`; the verified `2.1.0` history already folds the release-relevant work into a clean sequence.

For the `2.1.7` release batch, leave unmerged cached worktree branches untouched and revisit cleanup only after the release and CI settle.

## Safe-To-Delete Candidates After Verification

These branches appear superseded by final `2.1.0` behavior and should be deleted only after confirming there are no open worktrees or unpushed local notes:

- `codex/fix-tota11y-default`
- `codex/fix-mobile-submenu-aria-state`
- `codex/fix-toggle-button-semantics`
- `codex/form-live-announcements`
- `codex/reduced-motion-support`
- `codex/slider-accessibility-parity`
- `codex/cleanup-aria-hidden-videos`

## Keep For Backlog Or Maintainer Follow-Up

These branches map to issues or cleanup that should remain separate from `2.1.0` unless maintainers request them:

- `codex/divi5-audit`
- `codex/improve-developer-mode-output`
- `codex/prevent-hidden-submenu-focus`
- `codex/refresh-plugin-metadata`
- `codex/remove-redundant-link-role`
- `codex/restore-eslint-lint`
- `codex/return-focus-on-mobile-menu-esc`

## Worktree-Blocked Branches

Some branches are checked out in cached worktrees. Remove the corresponding cached worktree before deleting the branch:

- `codex/improve-developer-mode-output`
- `codex/prevent-hidden-submenu-focus`
- `codex/refresh-plugin-metadata`
- `codex/remove-redundant-link-role`
- `codex/restore-eslint-lint`
- `codex/return-focus-on-mobile-menu-esc`
