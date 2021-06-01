<?php

namespace App\IpInfo\Infrastructure\Console\Service;

use App\IpInfo\Infrastructure\Console\Questions\ConsoleQuestionInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class HandleQuestionsService
{
    private QuestionHelper $questionHelper;
    private InputInterface $input;
    private OutputInterface $output;

    public function __construct(QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $questionHelper;
        $this->input = $input;
        $this->output = $output;
    }

    public function ask(ConsoleQuestionInterface $consoleQuestion): ?string
    {
        return $this->questionHelper->ask($this->input, $this->output, $consoleQuestion->question());
    }
}
