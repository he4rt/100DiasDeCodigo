<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class TweetDTO implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $text,
        public string $createdAt,
        public UserDTO $author,
        public ?EntitiesDTO $entities,
        public int $retweetCount,
        public int $replyCount,
        public int $likeCount,
        public int $quoteCount,
        public int $viewCount,
        public string $lang,
        public bool $isReply,
        public ?string $inReplyToId,
        public ?string $conversationId,
        public ?string $inReplyToUserId,
        public ?string $inReplyToUsername,
        public mixed $quotedTweet,
        public mixed $retweetedTweet,
        public ?EntitiesDTO $extendedEntities = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            text: $data['text'],
            createdAt: $data['createdAt'],
            author: UserDTO::fromArray($data['author']),
            entities: isset($data['entities']) ? EntitiesDTO::fromArray($data['entities']) : null,
            retweetCount: $data['retweetCount'],
            replyCount: $data['replyCount'],
            likeCount: $data['likeCount'],
            quoteCount: $data['quoteCount'],
            viewCount: $data['viewCount'],
            lang: $data['lang'],
            isReply: $data['isReply'],
            inReplyToId: $data['inReplyToId'] ?? null,
            conversationId: $data['conversationId'] ?? null,
            inReplyToUserId: $data['inReplyToUserId'] ?? null,
            inReplyToUsername: $data['inReplyToUsername'] ?? null,
            quotedTweet: $data['quoted_tweet'] ?? null,
            retweetedTweet: $data['retweeted_tweet'] ?? null,
            extendedEntities: isset($data['extendedEntities']) ? EntitiesDTO::fromArray($data['extendedEntities']) : null,
        );
    }

    public function getUrl(): string
    {
        return 'https://twitter.com/he4rt/status/'.$this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'createdAt' => $this->createdAt,
            'author' => $this->author->jsonSerialize(),
            'entities' => $this->entities?->jsonSerialize(),
            'retweetCount' => $this->retweetCount,
            'replyCount' => $this->replyCount,
            'likeCount' => $this->likeCount,
            'quoteCount' => $this->quoteCount,
            'viewCount' => $this->viewCount,
            'lang' => $this->lang,
            'isReply' => $this->isReply,
            'inReplyToId' => $this->inReplyToId,
            'conversationId' => $this->conversationId,
            'inReplyToUserId' => $this->inReplyToUserId,
            'inReplyToUsername' => $this->inReplyToUsername,
            'quoted_tweet' => $this->quotedTweet,
            'retweeted_tweet' => $this->retweetedTweet,
            'extendedEntities' => $this->extendedEntities?->jsonSerialize(),
        ];
    }

    public function getFormattedText(): string
    {
        $text = $this->text;
        $replacements = [];

        if ($this->entities instanceof EntitiesDTO) {
            foreach ($this->entities->hashtags as $hashtag) {
                $replacements[] = [
                    'start' => $hashtag->indices[0],
                    'end' => $hashtag->indices[1],
                    'type' => 'hashtag',
                    'data' => $hashtag,
                ];
            }

            foreach ($this->entities->userMentions as $mention) {
                $replacements[] = [
                    'start' => $mention->indices[0],
                    'end' => $mention->indices[1],
                    'type' => 'mention',
                    'data' => $mention,
                ];
            }

            foreach ($this->entities->urls as $url) {
                $replacements[] = [
                    'start' => $url->indices[0],
                    'end' => $url->indices[1],
                    'type' => 'url',
                    'data' => $url,
                ];
            }

            foreach ($this->entities->media as $media) {
                $replacements[] = [
                    'start' => $media->indices[0],
                    'end' => $media->indices[1],
                    'type' => 'media',
                    'data' => $media,
                ];
            }
        }

        // Sort by start index descending to replace from end to start
        usort($replacements, fn (array $a, array $b) => $b['start'] <=> $a['start']);

        foreach ($replacements as $replacement) {
            $start = $replacement['start'];
            $end = $replacement['end'];

            $replacementText = '';

            switch ($replacement['type']) {
                case 'hashtag':
                    /** @var HashtagEntityDTO $data */
                    $data = $replacement['data'];
                    $replacementText = mb_strtolower($data->text) === '100diasdecodigo' ? '' : sprintf('<strong>#%s</strong>', $data->text);

                    break;
                case 'mention':
                    /** @var UserMentionEntityDTO $data */
                    $data = $replacement['data'];
                    $replacementText = sprintf('<a href="https://x.com/%s" class="text-blue-500 hover:underline" target="_blank">@%s</a>', $data->screenName, $data->screenName);
                    break;
                case 'url':
                    /** @var UrlEntityDTO $data */
                    $data = $replacement['data'];
                    $replacementText = sprintf('<a href="%s" class="text-blue-500 hover:underline" target="_blank">%s</a>', $data->url, $data->displayUrl);
                    break;
                case 'media':
                    $replacementText = '';
                    break;
            }

            // Using mb_substr for UTF-8 safety
            $pre = mb_substr($text, 0, $start);
            $post = mb_substr($text, $end);
            $text = $pre.$replacementText.$post;
        }

        // Remove pattern [xx/xx], ꒰ xx/xx ꒱, xx/xx
        $text = preg_replace('/(?:\[|\꒰)?\s*\d+\s*\/\s*\d+(?:\s*(?:\]|\꒱))?/', '', $text);

        return mb_ltrim($text);
    }
}
