<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use Symfony\Component\Console\Question\Question;

final class UseCustomIp implements ConsoleQuestionInterface
{
    private const QUESTION = 'Please input your custom IP address: ';

    private Question $question;

    public function __construct()
    {
        $this->question = new Question(self::QUESTION);
    }

    public function question(): Question
    {
        return $this->question;
    }
}
