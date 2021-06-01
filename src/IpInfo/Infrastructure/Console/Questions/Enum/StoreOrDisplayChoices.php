<?php

namespace App\IpInfo\Infrastructure\Console\Questions\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self STORE()
 * @method static self DISPLAY()
 */
class StoreOrDisplayChoices extends Enum
{
    public const STORE = 'store';
    public const DISPLAY = 'display';
}
