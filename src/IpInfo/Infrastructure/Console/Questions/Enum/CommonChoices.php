<?php

namespace App\IpInfo\Infrastructure\Console\Questions\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self YES()
 * @method static self NO()
 */
class CommonChoices extends Enum
{
    public const YES = 'yes';
    public const NO = 'no';
}
