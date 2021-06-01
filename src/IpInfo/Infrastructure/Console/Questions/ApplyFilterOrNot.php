<?php

namespace App\IpInfo\Infrastructure\Console\Questions;

use App\IpInfo\Infrastructure\Console\Questions\Enum\CommonChoices;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

final class ApplyFilterOrNot implements ConsoleQuestionInterface
{
    private const QUESTION = 'Would you like to apply filter?';
    private const ERROR_MESSAGE = '%s is invalid answer.';

    private ChoiceQuestion $question;

    public function __construct()
    {
        $choices = [
          CommonChoices::YES()->getValue(),
          CommonChoices::NO()->getValue(),
        ];

        $this->question = new ChoiceQuestion(self::QUESTION, $choices);
        $this->question->setErrorMessage(self::ERROR_MESSAGE);
    }

    public function question(): Question
    {
        return $this->question;
    }
}
