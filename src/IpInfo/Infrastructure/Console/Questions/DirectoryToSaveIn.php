<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use Symfony\Component\Console\Question\Question;

final class DirectoryToSaveIn implements ConsoleQuestionInterface
{
    private const QUESTION = 'Directory to save in: ';

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
