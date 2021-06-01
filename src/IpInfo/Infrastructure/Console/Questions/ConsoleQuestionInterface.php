<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use Symfony\Component\Console\Question\Question;

interface ConsoleQuestionInterface
{
    public function question(): Question;
}
