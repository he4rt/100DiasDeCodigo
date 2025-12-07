<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Enums;

enum QueryType: string
{
    case Latest = 'latest';
    case Top = 'top';
}
