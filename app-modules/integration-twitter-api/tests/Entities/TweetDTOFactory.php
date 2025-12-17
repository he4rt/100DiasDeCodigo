<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Tests\Entities;

use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;

class TweetDTOFactory
{
    public static function with(string $tweetId, string $userId, string $content): TweetDTO
    {
        $payload = [
            'type' => 'tweet',
            'id' => $tweetId ?? '2001233687787012177',
            'url' => 'https://x.com/cadusousa_/status/2001233687787012177',
            'twitterUrl' => 'https://twitter.com/cadusousa_/status/2001233687787012177',
            'text' => $content ?? '[29/100] #100DiasDeCodigo
Iniciei o processo de registro na parte de autenticação e esbarrei com algumas decisões sobre o SaaS no geral que acabei debatendo por um tempo com o Gemini pra entender diferentes abordagens, oq me fez ter q refatorar algumas coisas',
            'source' => 'Twitter for iPhone',
            'retweetCount' => 0,
            'replyCount' => 0,
            'likeCount' => 6,
            'quoteCount' => 0,
            'viewCount' => 17,
            'createdAt' => 'Wed Dec 17 10:11:06 +0000 2025',
            'lang' => 'pt',
            'bookmarkCount' => 0,
            'isReply' => false,
            'inReplyToId' => null,
            'conversationId' => '2001233687787012177',
            'displayTextRange' => [
                0,
                260,
            ],
            'inReplyToUserId' => null,
            'inReplyToUsername' => null,
            'author' => [
                'type' => 'user',
                'userName' => 'cadusousa_',
                'url' => 'https://x.com/cadusousa_',
                'twitterUrl' => 'https://twitter.com/cadusousa_',
                'id' => $userId ?? '1103420181139935234',
                'name' => 'cdz 🧑🏻‍💻',
                'isVerified' => false,
                'isBlueVerified' => false,
                'verifiedType' => null,
                'profilePicture' => 'https://pbs.twimg.com/profile_images/1993284911566839808/ACuLUjPN_normal.jpg',
                'coverPicture' => 'https://pbs.twimg.com/profile_banners/1103420181139935234/1620941555',
                'description' => '',
                'location' => 'Camaragibe, Brasil',
                'followers' => 204,
                'following' => 196,
                'status' => '',
                'canDm' => false,
                'canMediaTag' => false,
                'createdAt' => 'Wed Mar 06 22:20:46 +0000 2019',
                'entities' => [
                    'description' => [
                        'urls' => [],
                    ],
                    'url' => [],
                ],
                'fastFollowersCount' => 0,
                'favouritesCount' => 7995,
                'hasCustomTimelines' => true,
                'isTranslator' => false,
                'mediaCount' => 63,
                'statusesCount' => 4926,
                'withheldInCountries' => [],
                'affiliatesHighlightedLabel' => [],
                'possiblySensitive' => false,
                'pinnedTweetIds' => [
                    '1815501141339168992',
                ],
                'profile_bio' => [
                    'description' => 'Programador full stack. Leão do Norte. Reclama, mas da um jeito.',
                    'entities' => [
                        'description' => [],
                        'url' => [
                            'urls' => [
                                [
                                    'display_url' => 'instagram.com/cadusousa_',
                                    'expanded_url' => 'http://instagram.com/cadusousa_',
                                    'indices' => [
                                        0,
                                        23,
                                    ],
                                    'url' => 'https://t.co/ctWGHiT5Vt',
                                ],
                            ],
                        ],
                    ],
                ],
                'isAutomated' => false,
                'automatedBy' => null,
            ],
            'extendedEntities' => [],
            'card' => null,
            'place' => [],
            'entities' => [
                'hashtags' => [
                    [
                        'indices' => [
                            9,
                            25,
                        ],
                        'text' => '100DiasDeCodigo',
                    ],
                ],
            ],
            'quoted_tweet' => null,
            'retweeted_tweet' => null,
            'isLimitedReply' => false,
            'article' => null,
        ];

        return TweetDTO::fromArray($payload);
    }
}
