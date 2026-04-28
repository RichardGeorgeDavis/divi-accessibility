# Repository Instructions

## Git Remotes

- `origin` is the maintained release repository: `https://github.com/RichardGeorgeDavis/divi-accessibility.git`.
- `upstream` is the historical CampusPress repository: `https://github.com/campuspress/divi-accessibility.git`.
- Use `origin` for normal pushes, tags, and GitHub Releases.
- Keep `master` tracking `origin/master`. If `git status` reports `master...fork/master` or another upstream, run:

```sh
git branch --set-upstream-to=origin/master master
```

- Do not point `origin` at CampusPress; that repository denies normal fork-maintainer pushes and causes `git push origin` to fail with 403.
