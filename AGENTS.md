# Repository Instructions

## Git Remotes

- `fork` is the maintained release repository: `https://github.com/RichardGeorgeDavis/divi-accessibility.git`.
- `origin` fetches from the upstream historical repository: `https://github.com/campuspress/divi-accessibility.git`.
- `origin` pushes to the maintained release repository to support tools that run `git push origin`: `https://github.com/RichardGeorgeDavis/divi-accessibility.git`.
- Use `fork` for normal pushes, tags, and GitHub Releases.
- Keep `master` tracking `fork/master`. If `git status` reports `master...origin/master`, run:

```sh
git branch --set-upstream-to=fork/master master
```

- Do not change `origin`'s push URL back to CampusPress unless explicitly requested; that repository denies normal fork-maintainer pushes.
