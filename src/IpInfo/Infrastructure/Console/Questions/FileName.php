<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use Symfony\Component\Console\Question\Question;

final class FileName implements ConsoleQuestionInterface
{
    private const QUESTION = 'Please choose filename (Including extension, for example test.json): ';

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
