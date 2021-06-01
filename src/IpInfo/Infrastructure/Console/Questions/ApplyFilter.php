<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use Symfony\Component\Console\Question\Question;

final class ApplyFilter implements ConsoleQuestionInterface
{
    private const QUESTION = 'Please choose filter value: ';

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
