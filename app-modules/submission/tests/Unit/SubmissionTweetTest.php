<?php

declare(strict_types=1);

use He4rt\Submission\Models\Submission;

it('returns no tweet when the submission has no metadata', function (): void {
    $submission = new Submission(['metadata' => null]);

    expect($submission->getTweet())->toBeNull();
});

it('reads the progress from the content when the submission has no metadata', function (): void {
    $submission = new Submission([
        'metadata' => null,
        'content' => 'Dia 12 / 100 do desafio',
    ]);

    expect($submission->progress)->toBe('12/100');
});
