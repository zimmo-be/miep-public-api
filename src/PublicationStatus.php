<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

interface PublicationStatus
{
    public const CREATED = 'CREATED';
    public const UPDATED = 'UPDATED';
    public const REMOVED = 'REMOVED';
}
