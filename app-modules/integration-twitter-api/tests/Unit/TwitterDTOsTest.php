<?php

declare(strict_types=1);

use He4rt\IntegrationTwitterApi\DTOs\TimelineResponse;
use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;

it('can parse twitter timeline response', function (): void {

    $json = <<<'JSON'
        {
          "tweets": [
            {
              "type": "tweet",
              "id": "1234567890",
              "url": "https://twitter.com/user/status/1234567890",
              "text": "Hello World",
              "source": "<a href=\"...\">Twitter for iPhone</a>",
              "retweetCount": 10,
              "replyCount": 5,
              "likeCount": 100,
              "quoteCount": 2,
              "viewCount": 500,
              "createdAt": "Fri Dec 06 12:00:00 +0000 2024",
              "lang": "en",
              "bookmarkCount": 1,
              "isReply": false,
              "inReplyToId": null,
              "conversationId": "1234567890",
              "displayTextRange": [
                0,
                11
              ],
              "inReplyToUserId": null,
              "inReplyToUsername": null,
              "author": {
                "type": "user",
                "userName": "testuser",
                "url": "https://twitter.com/testuser",
                "id": "987654321",
                "name": "Test User",
                "isBlueVerified": true,
                "verifiedType": "blue",
                "profilePicture": "https://pbs.twimg.com/profile_images/...",
                "coverPicture": "https://pbs.twimg.com/profile_banners/...",
                "description": "Just a test user",
                "location": "Internet",
                "followers": 1000,
                "following": 500,
                "canDm": true,
                "createdAt": "Fri Jan 01 12:00:00 +0000 2020",
                "favouritesCount": 200,
                "hasCustomTimelines": false,
                "isTranslator": false,
                "mediaCount": 50,
                "statusesCount": 1000,
                "withheldInCountries": [],
                "affiliatesHighlightedLabel": {},
                "possiblySensitive": false,
                "pinnedTweetIds": [],
                "isAutomated": false,
                "automatedBy": null,
                "unavailable": false,
                "message": null,
                "unavailableReason": null,
                "profile_bio": {
                  "description": "Just a test user",
                  "entities": {
                    "description": {
                      "urls": [
                        {
                          "display_url": "example.com",
                          "expanded_url": "https://example.com",
                          "indices": [
                            0,
                            23
                          ],
                          "url": "https://t.co/xyz"
                        }
                      ]
                    },
                    "url": {
                      "urls": [
                        {
                          "display_url": "example.com",
                          "expanded_url": "https://example.com",
                          "indices": [
                            0,
                            23
                          ],
                          "url": "https://t.co/xyz"
                        }
                      ]
                    }
                  }
                }
              },
              "entities": {
                "hashtags": [
                  {
                    "indices": [
                      0,
                      5
                    ],
                    "text": "hello"
                  }
                ],
                "urls": [
                  {
                    "display_url": "example.com",
                    "expanded_url": "https://example.com",
                    "indices": [
                      6,
                      29
                    ],
                    "url": "https://t.co/abc"
                  }
                ],
                "user_mentions": [
                  {
                    "id_str": "11111",
                    "name": "Mentioned User",
                    "screen_name": "mentioned",
                    "indices": [
                      30,
                      40
                    ]
                  }
                ]
              },
              "quoted_tweet": null,
              "retweeted_tweet": null,
              "isLimitedReply": false
            }
          ],
          "has_next_page": true,
          "next_cursor": "cursor123"
        }
        JSON;

    $data = json_decode($json, true);

    $timeline = TimelineResponse::fromArray($data);

    $this->assertInstanceOf(TimelineResponse::class, $timeline);
    $this->assertCount(1, $timeline->tweets);
    $this->assertTrue($timeline->hasNextPage);
    $this->assertEquals('cursor123', $timeline->nextCursor);

    $tweet = $timeline->tweets[0];
    $this->assertEquals('1234567890', $tweet->id);
    $this->assertEquals('Hello World', $tweet->text);
    $this->assertEquals('testuser', $tweet->author->userName);
    $this->assertCount(1, $tweet->entities->hashtags);
    $this->assertEquals('hello', $tweet->entities->hashtags[0]->text);
    $this->assertCount(1, $tweet->author->profileBio->entities->descriptionUrls);
    $this->assertEquals('https://t.co/xyz', $tweet->author->profileBio->entities->descriptionUrls[0]->url);

    $encoded = json_encode($timeline);
    $decoded = json_decode($encoded, true);

    $this->assertEquals($data['tweets'][0]['id'], $decoded['tweets'][0]['id']);
    $this->assertEquals($data['has_next_page'], $decoded['has_next_page']);
    $this->assertEquals($data['next_cursor'], $decoded['next_cursor']);
});

it('can format tweet text correctly', function (): void {
    $json = <<<'JSON'
{
  "type": "tweet",
  "id": "1997360967722684923",
  "url": "https://x.com/danielhe4rt/status/1997360967722684923",
  "twitterUrl": "https://twitter.com/danielhe4rt/status/1997360967722684923",
  "url": "https://x.com/danielhe4rt/status/1997360967722684923",
  "twitterUrl": "https://twitter.com/danielhe4rt/status/1997360967722684923",
  "text": "[1/100] \n\nLIVECODING ON!\n\nHoje é dia de terminar a plataforma do #100DiasDeCodigo e te convido aqui e agora pra  aprender a como consumir API's de terceiros usando o fino da orientação à objetos.\n\nLink da live na thread 👇 https://t.co/iYw029Fnaq",
  "source": "Twitter for iPhone",
  "source": "Twitter for iPhone",
  "retweetCount": 1,
  "replyCount": 2,
  "likeCount": 15,
  "quoteCount": 0,
  "viewCount": 454,
  "createdAt": "Sat Dec 06 17:42:18 +0000 2025",
  "lang": "pt",
  "bookmarkCount": 0,
  "isReply": false,
  "inReplyToId": null,
  "conversationId": "1997360967722684923",
  "displayTextRange": [
    0,
    211
  ],
  "inReplyToUserId": null,
  "inReplyToUsername": null,
  "author": {
    "type": "user",
    "userName": "danielhe4rt",
    "url": "https://x.com/danielhe4rt",
    "twitterUrl": "https://twitter.com/danielhe4rt",
    "id": "1229110016",
    "name": "danielhe4rt.php",
    "isVerified": false,
    "isBlueVerified": true,
    "verifiedType": null,
    "profilePicture": "https://pbs.twimg.com/profile_images/1772258918619566080/tsg0-uCZ_normal.jpg",
    "coverPicture": "https://pbs.twimg.com/profile_banners/1229110016/1668293664",
    "description": "🇧🇷 26 yo doing useless code since 2011 \n\nphp and laravel is the way",
    "location": "discord.gg/he4rt",
    "followers": 41168,
    "following": 2190,
    "status": "",
    "canDm": true,
    "canMediaTag": true,
    "createdAt": "Fri Mar 01 05:42:42 +0000 2013",
    "entities": {
      "description": {
        "urls": []
      },
      "url": {
        "urls": [
          {
            "display_url": "basementdevs.academy",
            "expanded_url": "http://basementdevs.academy",
            "url": "https://t.co/yBxx7RdqHh",
            "indices": [
              0,
              23
            ]
          }
        ]
      }
    },
    "fastFollowersCount": 0,
    "favouritesCount": 61260,
    "hasCustomTimelines": true,
    "isTranslator": false,
    "mediaCount": 4710,
    "statusesCount": 40183,
    "withheldInCountries": [],
    "affiliatesHighlightedLabel": [],
    "possiblySensitive": false,
    "pinnedTweetIds": [
      "1776892758063493307"
    ],
    "profile_bio": [],
    "isAutomated": false,
    "automatedBy": null
  },
  "extendedEntities": {
    "media": [
      {
        "display_url": "pic.x.com/iYw029Fnaq",
        "expanded_url": "https://x.com/danielhe4rt/status/1997360967722684923/photo/1",
        "id_str": "1997360639686168576",
        "indices": [
          212,
          235
        ],
        "media_key": "3_1997360639686168576",
        "media_url_https": "https://pbs.twimg.com/media/G7gM61jXUAAqkP2.jpg",
        "type": "photo",
        "url": "https://t.co/iYw029Fnaq",
        "ext_media_availability": {
          "status": "Available"
        },
        "features": {
          "large": {
            "faces": [
              {
                "x": 1737,
                "y": 857,
                "h": 145,
                "w": 145
              }
            ]
          },
          "medium": {
            "faces": [
              {
                "x": 1018,
                "y": 502,
                "h": 85,
                "w": 85
              }
            ]
          },
          "small": {
            "faces": [
              {
                "x": 576,
                "y": 284,
                "h": 48,
                "w": 48
              }
            ]
          },
          "orig": {
            "faces": [
              {
                "x": 2172,
                "y": 1072,
                "h": 182,
                "w": 182
              }
            ]
          }
        },
        "sizes": {
          "large": {
            "h": 1152,
            "w": 2048,
            "resize": "fit"
          },
          "medium": {
            "h": 675,
            "w": 1200,
            "resize": "fit"
          },
          "small": {
            "h": 383,
            "w": 680,
            "resize": "fit"
          },
          "thumb": {
            "h": 150,
            "w": 150,
            "resize": "crop"
          }
        },
        "original_info": {
          "height": 1440,
          "width": 2560,
          "focus_rects": [
            {
              "x": 0,
              "y": 6,
              "w": 2560,
              "h": 1434
            },
            {
              "x": 1120,
              "y": 0,
              "w": 1440,
              "h": 1440
            },
            {
              "x": 1297,
              "y": 0,
              "w": 1263,
              "h": 1440
            },
            {
              "x": 1840,
              "y": 0,
              "w": 720,
              "h": 1440
            },
            {
              "x": 0,
              "y": 0,
              "w": 2560,
              "h": 1440
            }
          ]
        },
        "allow_download_status": {
          "allow_download": true
        },
        "media_results": {
          "result": {
            "media_key": "3_1997360639686168576"
          }
        }
      }
    ]
  },
  "card": null,
  "place": [],
  "entities": {
    "hashtags": [
      {
        "indices": [
          55,
          71
        ],
        "text": "100DiasDeCodigo"
      }
    ],
    "media": [
      {
        "display_url": "pic.x.com/iYw029Fnaq",
        "expanded_url": "https://x.com/danielhe4rt/status/1997360967722684923/photo/1",
        "id_str": "1997360639686168576",
        "indices": [
          212,
          235
        ],
        "media_key": "3_1997360639686168576",
        "media_url_https": "https://pbs.twimg.com/media/G7gM61jXUAAqkP2.jpg",
        "type": "photo",
        "url": "https://t.co/iYw029Fnaq",
        "ext_media_availability": {
          "status": "Available"
        },
        "features": {
          "large": {
            "faces": [
              {
                "x": 1737,
                "y": 857,
                "h": 145,
                "w": 145
              }
            ]
          },
          "medium": {
            "faces": [
              {
                "x": 1018,
                "y": 502,
                "h": 85,
                "w": 85
              }
            ]
          },
          "small": {
            "faces": [
              {
                "x": 576,
                "y": 284,
                "h": 48,
                "w": 48
              }
            ]
          },
          "orig": {
            "faces": [
              {
                "x": 2172,
                "y": 1072,
                "h": 182,
                "w": 182
              }
            ]
          }
        },
        "sizes": {
          "large": {
            "h": 1152,
            "w": 2048,
            "resize": "fit"
          },
          "medium": {
            "h": 675,
            "w": 1200,
            "resize": "fit"
          },
          "small": {
            "h": 383,
            "w": 680,
            "resize": "fit"
          },
          "thumb": {
            "h": 150,
            "w": 150,
            "resize": "crop"
          }
        },
        "original_info": {
          "height": 1440,
          "width": 2560,
          "focus_rects": [
            {
              "x": 0,
              "y": 6,
              "w": 2560,
              "h": 1434
            },
            {
              "x": 1120,
              "y": 0,
              "w": 1440,
              "h": 1440
            },
            {
              "x": 1297,
              "y": 0,
              "w": 1263,
              "h": 1440
            },
            {
              "x": 1840,
              "y": 0,
              "w": 720,
              "h": 1440
            },
            {
              "x": 0,
              "y": 0,
              "w": 2560,
              "h": 1440
            }
          ]
        },
        "allow_download_status": {
          "allow_download": true
        },
        "media_results": {
          "result": {
            "media_key": "3_1997360639686168576"
          }
        }
      }
    ],
    "symbols": [],
    "timestamps": [],
    "urls": [],
    "user_mentions": []
  },
  "quoted_tweet": null,
  "retweeted_tweet": null
}
JSON;

    $data = json_decode($json, true);
    $dto = TweetDTO::fromArray($data);

    $formatted = $dto->getFormattedText();

    expect($formatted)->not->toContain('#100DiasDeCodigo')
        ->not->toContain('https://t.co/iYw029Fnaq')
        ->not->toContain('[1/100]');

});
