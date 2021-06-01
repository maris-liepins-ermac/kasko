<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use Symfony\Component\Console\Question\Question;

final class UseAuthToken implements ConsoleQuestionInterface
{
    private const QUESTION = 'Please input your auth token: ';

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
