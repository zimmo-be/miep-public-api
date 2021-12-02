<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties\Http;

use Teapot\StatusCode\All;
use Teapot\StatusCode\RFC\RFC6585;

interface StatusCode extends All, RFC6585
{
}
