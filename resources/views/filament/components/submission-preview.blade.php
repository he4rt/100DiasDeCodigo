@props (['submission'])

@php
    if (is_array($submission)) {
        $submission = \He4rt\IntegrationTwitterApi\DTOs\TweetDTO::fromArray($submission);
    }
@endphp

<div class="space-y-4 pt-3">
    <x-submission::submission-card :$submission />
</div>
