<?php

namespace App\IpInfo\Infrastructure\Console\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self NAMESPACE()
 * @method static self REQUEST()
 */
final class CommandsList extends Enum
{
    public const NAMESPACE = 'ip-info';
    public const REQUEST = 'request';
}
