<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch;

use He4rt\IntegrationTwitterApi\Enums\QueryType;
use JsonSerializable;

final class AdvancedSearchRequest implements JsonSerializable
{
    public function __construct(
        public string $query,
        public QueryType $queryType = QueryType::Latest,
        public string $cursor = ''
    ) {}

    public static function make(string $query, QueryType $queryType = QueryType::Latest, string $cursor = ''): self
    {
        return new self($query, $queryType, $cursor);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'query' => $this->query,
            'queryType' => $this->queryType->value,
            'cursor' => $this->cursor,
        ];
    }
}
