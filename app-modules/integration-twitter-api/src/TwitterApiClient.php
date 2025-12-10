<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi;

use Exception;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchRequest;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchResponse;
use He4rt\IntegrationTwitterApi\Endpoints\FindTweet\FindTweetRequest;
use He4rt\IntegrationTwitterApi\Endpoints\FindTweet\FindTweetResponse;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final readonly class TwitterApiClient
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(config('services.twitter.base_url'))
            ->withHeader('X-API-KEY', config('services.twitter.api_key'));
    }

    public function advancedSearch(AdvancedSearchRequest $request): AdvancedSearchResponse
    {
        $response = $this
            ->client
            ->withQueryParameters($request->jsonSerialize())
            ->get('/twitter/tweet/advanced_search');

        if ($response->failed()) {
            throw new Exception($response->body());
        }

        return AdvancedSearchResponse::fromArray($response->json());
    }

    public function findTweets(FindTweetRequest $request): FindTweetResponse
    {
        $response = $this
            ->client
            ->withQueryParameters($request->jsonSerialize())
            ->get('/twitter/tweets');

        if ($response->failed()) {
            throw new Exception($response->body());
        }

        return FindTweetResponse::fromArray($response->json());
    }
}
