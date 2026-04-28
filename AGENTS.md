# Repository Instructions

## Git Remotes

- `fork` is the maintained release repository: `https://github.com/RichardGeorgeDavis/divi-accessibility.git`.
- `origin` is the upstream historical repository: `https://github.com/campuspress/divi-accessibility.git`.
- Use `fork` for normal pushes, tags, and GitHub Releases.
- Keep `master` tracking `fork/master`. If `git status` reports `master...origin/master`, run:

```sh
git branch --set-upstream-to=fork/master master
```

- Do not push release commits or tags to `origin` unless explicitly requested.
