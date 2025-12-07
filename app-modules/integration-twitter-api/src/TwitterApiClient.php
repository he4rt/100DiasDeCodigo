<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi;

use Exception;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchRequest;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchResponse;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final readonly class TwitterApiClient
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.twitterapi.io')
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

        dump($response->json());

        return AdvancedSearchResponse::fromArray($response->json());
    }
}
