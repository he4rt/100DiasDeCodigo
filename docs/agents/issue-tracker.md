# Issue tracker: GitHub

Issues and specs for this repo live as GitHub issues on `he4rt/100DiasDeCodigo`. Use the `gh` CLI for all operations.

## Conventions

- **Create an issue**: `gh issue create --title "..." --body "..."`. Use a heredoc for multi-line bodies.
- **Read an issue**: `gh issue view <number> --json number,title,body,labels,comments --jq '{number, title, body, labels: [.labels[].name], comments: [.comments[] | {author: .author.login, body}]}'`. Do not rely on `--comments` alone: piped output prints only the comments, and `--jq` needs `--json`.
- **List issues**: `gh issue list --state open --limit 200 --json number,title,body,labels,comments --jq '[.[] | {number, title, body, labels: [.labels[].name], comments: [.comments[].body]}]'` with appropriate `--label` and `--state` filters. The default limit is 30; raise `--limit` until the result count is below it, so bulk operations do not miss issues.
- **Comment on an issue**: `gh issue comment <number> --body "..."`
- **Apply / remove labels**: `gh issue edit <number> --add-label "..."` / `--remove-label "..."`
- **Close**: `gh issue close <number>`
- Confirm with the user before **bulk** operations or **closing/deleting** issues.

Infer the repo from `git remote -v` — `gh` does this automatically when run inside a clone.

Every new issue gets one `type:*` label and at least one `mod:*` label, next to its triage label. See `docs/agents/triage-labels.md`. If a label does not exist yet, create it first with `gh label create`.

## When implementation of an issue starts

When work on an issue starts (usually through `/implement`), assign the issue to the developer who implements it before the first commit. `@me` resolves to the authenticated `gh` user:

```bash
gh issue edit <number> --add-assignee @me
```

## Opening a pull request

- **Link an issue.** Every PR has a related issue, referenced in the body with `Closes #<n>`. This is a strong default, not an absolute rule: a small or tooling-only change can go without an issue. When you skip the issue, say why in the PR body.
- **Assign the implementer.** Always open the PR with `--assignee @me`, so the developer who did the work owns it.
- **Apply labels.** Copy the `type:*` and `mod:*` labels of the linked issue. Without an issue, pick them from the diff. Do not copy triage labels (`needs-*`, `ready-for-*`) to a PR.
- **Branch.** Open the PR from a branch that follows `docs/agents/branch-naming.md`. Never push directly to a `<major>.x` line.
- **Not a draft.** CI skips draft PRs. Open a ready PR, or mark it ready for review, to start the pipeline.

```bash
gh pr create --base 1.x --assignee @me \
    --label "type:feat,mod:<module>" \
    --title "<type>(<module>): <subject>" \
    --body "$(cat <<'EOF'
...

Closes #<n>
EOF
)"
```

## Pull requests as a triage surface

**PRs as a request surface: no.** _(Set to `yes` if this repo treats external PRs as feature requests; `/triage` reads this flag.)_

When set to `yes`, PRs run through the same labels and states as issues, using the `gh pr` equivalents:

- **Read a PR**: `gh pr view <number> --comments` and `gh pr diff <number>` for the diff.
- **List external PRs for triage**: `gh pr list --state open --json number,title,body,labels,author,authorAssociation,comments` then keep only `authorAssociation` of `CONTRIBUTOR`, `FIRST_TIME_CONTRIBUTOR`, or `NONE`.
- **Comment / label / close**: `gh pr comment`, `gh pr edit --add-label`/`--remove-label`, `gh pr close`.

GitHub shares one number space across issues and PRs, so a bare `#42` may be either — resolve with `gh pr view 42` and fall back to `gh issue view 42`.

## When a skill says "publish to the issue tracker"

Create a GitHub issue.

## When a skill says "fetch the relevant ticket"

Run `gh issue view <number> --json number,title,body,labels,comments` (see **Read an issue** above).

## Wayfinding operations

Used by `/wayfinder`. The **map** is a single issue with **child** issues as tickets.

- **Map**: a single issue labelled `wayfinder:map`, holding the Notes / Decisions-so-far / Fog body.
- **Child ticket**: a sub-issue of the map. Labels: `wayfinder:<type>` (`research`/`prototype`/`grilling`/`task`). Once claimed, the ticket is assigned to the driving dev.
- **Blocking**: native `blocked_by` edges (see below). A ticket is unblocked when every blocker is closed.
- **Frontier query**: the map's open children with no open blocker (`issue_dependencies_summary.blocked_by == 0`) and no assignee; first in map order wins.
- **Claim**: `gh issue edit <n> --add-assignee @me` — the session's first write.
- **Resolve**: `gh issue comment <n> --body "<answer>"`, then `gh issue close <n>`, then append a context pointer to the map's Decisions-so-far.

## Issue relationships (native)

Use GitHub's **native** relationships instead of plain-text "Blocked by" lines. Set them after the issues exist (publish parents and blockers first, so their ids can be referenced).

- **Spec/epic → tickets**: parent / sub-issue. `gh api --method POST repos/{owner}/{repo}/issues/{PARENT}/sub_issues -F sub_issue_id=<child REST id>`.
- **Ticket blocking edges**: `gh api --method POST repos/{owner}/{repo}/issues/{N}/dependencies/blocked_by -F issue_id=<blocker REST id>` (creates the inverse "blocking" automatically).
- **Relates to**: no public API — set manually in the Relationships panel when useful.
- **Read edges**: `.../issues/{N}/dependencies/blocked_by`, `.../issues/{N}/dependencies/blocking`, `.../issues/{PARENT}/sub_issues`.

Use the REST numeric `id` (`gh api repos/{owner}/{repo}/issues/{N} --jq .id`), never the issue `number` nor the GraphQL node id. Use `-F` (typed), not `-f`, or the id is rejected as a string (`422 not of type integer`).
