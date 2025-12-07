<?php

declare(strict_types=1);

use He4rt\Submission\Models\Submission;

it('can extract progress from tweet text', function (): void {
    $submission = new Submission();
    $submission->metadata = [
        'id' => '123',
        'text' => '[1/100] Hello World',
        'createdAt' => '2024-01-01',
        'author' => [
            'id' => '1',
            'name' => 'Test',
            'userName' => 'test',
            'profilePicture' => '',
            'description' => '',
            'location' => '',
            'followers' => 0,
            'following' => 0,
            'isBlueVerified' => false,
            'canDm' => false,
            'createdAt' => '2024-01-01',
            'favouritesCount' => 0,
            'mediaCount' => 0,
            'statusesCount' => 0,
        ],
        'retweetCount' => 0,
        'replyCount' => 0,
        'likeCount' => 0,
        'quoteCount' => 0,
        'viewCount' => 0,
        'lang' => 'en',
        'isReply' => false,
    ];

    expect($submission->progress)->toBe('1/100');
});

it('can extract progress with curly braces', function (): void {
    $submission = new Submission();
    $submission->metadata = [
        'id' => '123',
        'text' => '꒰ 4 / 100 ꒱ Hello World',
        'createdAt' => '2024-01-01',
        'author' => [
            'id' => '1',
            'name' => 'Test',
            'userName' => 'test',
            'profilePicture' => '',
            'description' => '',
            'location' => '',
            'followers' => 0,
            'following' => 0,
            'isBlueVerified' => false,
            'canDm' => false,
            'createdAt' => '2024-01-01',
            'favouritesCount' => 0,
            'mediaCount' => 0,
            'statusesCount' => 0,
        ],
        'retweetCount' => 0,
        'replyCount' => 0,
        'likeCount' => 0,
        'quoteCount' => 0,
        'viewCount' => 0,
        'lang' => 'en',
        'isReply' => false,
    ];

    expect($submission->progress)->toBe('4/100');
});

it('can extract progress without brackets', function (): void {
    $submission = new Submission();
    $submission->metadata = [
        'id' => '123',
        'text' => '4 / 100 Hello World',
        'createdAt' => '2024-01-01',
        'author' => [
            'id' => '1',
            'name' => 'Test',
            'userName' => 'test',
            'profilePicture' => '',
            'description' => '',
            'location' => '',
            'followers' => 0,
            'following' => 0,
            'isBlueVerified' => false,
            'canDm' => false,
            'createdAt' => '2024-01-01',
            'favouritesCount' => 0,
            'mediaCount' => 0,
            'statusesCount' => 0,
        ],
        'retweetCount' => 0,
        'replyCount' => 0,
        'likeCount' => 0,
        'quoteCount' => 0,
        'viewCount' => 0,
        'lang' => 'en',
        'isReply' => false,
    ];

    expect($submission->progress)->toBe('4/100');
});

it('returns null if no progress found', function (): void {
    $submission = new Submission();
    $submission->metadata = [
        'id' => '123',
        'text' => 'Hello World',
        'createdAt' => '2024-01-01',
        'author' => [
            'id' => '1',
            'name' => 'Test',
            'userName' => 'test',
            'profilePicture' => '',
            'description' => '',
            'location' => '',
            'followers' => 0,
            'following' => 0,
            'isBlueVerified' => false,
            'canDm' => false,
            'createdAt' => '2024-01-01',
            'favouritesCount' => 0,
            'mediaCount' => 0,
            'statusesCount' => 0,
        ],
        'retweetCount' => 0,
        'replyCount' => 0,
        'likeCount' => 0,
        'quoteCount' => 0,
        'viewCount' => 0,
        'lang' => 'en',
        'isReply' => false,
    ];

    expect($submission->progress)->toBeNull();
});
