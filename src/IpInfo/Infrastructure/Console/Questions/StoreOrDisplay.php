<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use App\IpInfo\Infrastructure\Console\Questions\Enum\StoreOrDisplayChoices;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

final class StoreOrDisplay implements ConsoleQuestionInterface
{
    private const QUESTION = 'Would you like to store or display response?';
    private const ERROR_MESSAGE = '%s is invalid answer.';

    private ChoiceQuestion $question;

    public function __construct()
    {
        $choices = [
          StoreOrDisplayChoices::DISPLAY()->getValue(),
          StoreOrDisplayChoices::STORE()->getValue(),
        ];

        $this->question = new ChoiceQuestion(self::QUESTION, $choices);
        $this->question->setErrorMessage(self::ERROR_MESSAGE);
    }

    public function question(): Question
    {
        return $this->question;
    }
}
