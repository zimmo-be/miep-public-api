<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

interface PublicationStatus
{
    public const CREATED     = 'CREATED';
    public const UPDATED     = 'UPDATED';
    public const REMOVED     = 'REMOVED';
    public const NOT_CREATED = 'NOT_CREATED';
    public const NOT_UPDATED = 'NOT_UPDATED';
    public const NOT_REMOVED = 'NOT_REMOVED';
}
