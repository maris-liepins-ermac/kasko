<?php

namespace App\IpInfo\Infrastructure\Console;

use App\IpInfo\Infrastructure\Api\ApiClient;
use App\IpInfo\Infrastructure\Api\Dto\IpAddressDataDto;
use App\IpInfo\Infrastructure\Console\Enum\CommandsList;
use App\IpInfo\Infrastructure\Console\Questions\ApplyFilter;
use App\IpInfo\Infrastructure\Console\Questions\ApplyFilterOrNot;
use App\IpInfo\Infrastructure\Console\Questions\DirectoryToSaveIn;
use App\IpInfo\Infrastructure\Console\Questions\Enum\CommonChoices;
use App\IpInfo\Infrastructure\Console\Questions\Enum\StoreOrDisplayChoices;
use App\IpInfo\Infrastructure\Console\Questions\FileName;
use App\IpInfo\Infrastructure\Console\Questions\StoreOrDisplay;
use App\IpInfo\Infrastructure\Console\Questions\UseAuthToken;
use App\IpInfo\Infrastructure\Console\Questions\UseAuthTokenOrNot;
use App\IpInfo\Infrastructure\Console\Questions\UseCustomIp;
use App\IpInfo\Infrastructure\Console\Questions\UseCustomIpOrNot;
use App\IpInfo\Infrastructure\Console\Service\FormatApiResponseService;
use App\IpInfo\Infrastructure\Console\Service\HandleQuestionsService;
use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\FileDto;
use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\StoreInputDto;
use App\IpInfo\Infrastructure\Storage\StorageInterface;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RequestIpInfoData extends Command
{
    private ApiClient $apiClient;
    private FormatApiResponseService $formatApiResponseService;
    private StorageInterface $storage;

    public function __construct(
        ApiClient $apiClient,
        FormatApiResponseService $formatApiResponseService,
        StorageInterface $storage
    ) {
        parent::__construct();
        $this->apiClient = $apiClient;
        $this->formatApiResponseService = $formatApiResponseService;
        $this->storage = $storage;
    }

    protected function configure(): void
    {
        $this
            ->setName(sprintf('%s:%s', CommandsList::NAMESPACE, CommandsList::REQUEST))
            ->setDescription('Requests data from IP-Info API')
            ->setHelp('This command allows you to request data from API and save it or display it.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '============',
            '<info>Ip Info API</info>',
            '<comment>Developed as homework for KASKO</comment>',
            '============',
        ]);

        $questionHandler = new HandleQuestionsService(
            $this->getHelper('question'),
            $input,
            $output
        );

        $ip = null;
        $filter = null;
        $authToken = null;

        $useCustomIp = $questionHandler->ask(new UseCustomIpOrNot());
        if (CommonChoices::YES()->getValue() == $useCustomIp) {
            $ip = $questionHandler->ask(new UseCustomIp());
        }

        $useAuthToken = $questionHandler->ask(new UseAuthTokenOrNot());
        if (CommonChoices::YES()->getValue() == $useAuthToken) {
            $authToken = $questionHandler->ask(new UseAuthToken());
        }

        $applyFilters = $questionHandler->ask(new ApplyFilterOrNot());
        if (CommonChoices::YES()->getValue() == $applyFilters) {
            $filter = $questionHandler->ask(new ApplyFilter());
        }

        $payload = new IpAddressDataDto($ip, $authToken, $filter);
        $response = $this->apiClient->ipAddressData($payload);

        if (!$response->success()) {
            $output->writeln(['<error>Request was not successful</error>']);
            $output->writeln(['<info>'.$response->response().'</info>']);

            return Command::FAILURE;
        }

        $action = $questionHandler->ask(new StoreOrDisplay());
        if (StoreOrDisplayChoices::DISPLAY()->getValue() == $action) {
            $table = $this->formatApiResponseService->toTable($response, $output, $filter);
            $table->render();
        } elseif (StoreOrDisplayChoices::STORE()->getValue() == $action) {
            $success = false;
            while (!$success) {
                $directory = $questionHandler->ask(new DirectoryToSaveIn());
                $fileName = $questionHandler->ask(new FileName());
                try {
                    $this->storage->store(
                        new StoreInputDto(
                            $response->response(),
                            new FileDto($fileName, $directory)
                        )
                    );
                    $success = true;
                } catch (RuntimeException $runtimeException) {
                    $output->writeln(['<error>'.$runtimeException->getMessage().'</error>']);
                    $output->writeln(['<info>Please try again!</info>']);
                }
            }
        } else {
            $output->writeln([
                '<comment>Not sure what you\'re requesting</comment>',
            ]);
        }

        $output->writeln([
            '============',
            '<info>Done!</info>',
            '============',
        ]);

        return Command::SUCCESS;
    }
}
