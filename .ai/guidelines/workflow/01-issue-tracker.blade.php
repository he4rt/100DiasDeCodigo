@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Issue tracker: GitHub

Issues and PRDs for this repo are GitHub issues on `he4rt/100DiasDeCodigo`. Use the `gh` CLI for all operations. `gh` reads the repo from `git remote -v`, so never hard-code the `owner/repo`.

## When a skill says "publish to the issue tracker"

Create a real GitHub issue with `gh`. Apply the triage, type, module and difficulty labels from `workflow/triage-labels`. Then show the URL of the new issue to the user:

@verbatim
<code-snippet name="Create an issue" lang="bash">
gh issue create \
    --title "<type>(<module>): <short description>" \
    --body "<markdown body>" \
    --label "type:feat,mod:submission,needs-triage"
</code-snippet>
@endverbatim

Use a heredoc for a multi-line body.

## When a skill says "fetch the relevant ticket"

Read the issue from GitHub. Do not ask the user to paste it. Always include `--comments`: the resolution is usually in the thread (reporter clarifications, the answer to a `needs-info` question, "dupe of #50"), not in the first post:

@verbatim
<code-snippet name="Read / list issues" lang="bash">
gh issue view <number> --comments
gh issue list --state open --label "needs-triage"
</code-snippet>
@endverbatim

## Pull requests are not a triage surface

The triage queue is **GitHub Issues**. `/triage` does not read pull requests. Pull requests go through normal code review.

Issues and pull requests share one number space, so a bare `#42` can be either. Try `gh pr view 42` first, then `gh issue view 42`.

## Triage labels

The taxonomy in `workflow/triage-labels` maps to **GitHub labels**. Apply them with `gh issue edit <number> --add-label "..."`. If a label does not exist yet, create it first:

@verbatim
<code-snippet name="Create a missing label" lang="bash">
gh label create "mod:<name>" --description "<short description>" --color "c2e0c6"
</code-snippet>
@endverbatim

## Native relationships

Set parent/sub-issue and blocked-by links with the native GitHub relationships, not with plain-text lines in the body. Use the REST numeric `id` of the target issue (`gh api repos/{owner}/{repo}/issues/<N> --jq .id`) and pass it with `-F`:

@verbatim
<code-snippet name="Sub-issue and blocked-by" lang="bash">
gh api --method POST repos/{owner}/{repo}/issues/<PARENT>/sub_issues -F sub_issue_id=<child id>
gh api --method POST repos/{owner}/{repo}/issues/<N>/dependencies/blocked_by -F issue_id=<blocker id>
</code-snippet>
@endverbatim

## Conventions

- **Create an issue**: `gh issue create --title "..." --body "..."`. Use a heredoc for a multi-line body.
- **Read an issue**: `gh issue view <number> --comments`. Also read the labels.
- **List issues**: `gh issue list --state open --json number,title,body,labels,comments --jq '[.[] | {number, title, body, labels: [.labels[].name], comments: [.comments[].body]}]'` with the necessary `--label` and `--state` filters.
- **Comment on an issue**: `gh issue comment <number> --body "..."`
- **Apply / remove labels**: `gh issue edit <number> --add-label "..."` / `--remove-label "..."`
- **Close**: `gh issue close <number>`
- Ask the user before **bulk** operations and before you **close or delete** an issue. Other people see these changes, and they are hard to undo.
