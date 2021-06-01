<?php

namespace App\IpInfo\Infrastructure\Console\Service;

use App\IpInfo\Infrastructure\HttpClient\ApiResponse;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

final class FormatApiResponseService
{
    private const UNKNOWN_HEADER = 'Unknown header';

    public function toTable(ApiResponse $apiResponse, OutputInterface $output, ?string $filter = null): Table
    {
        $decodedResponse = json_decode($apiResponse->response(), true);

        if (null === $decodedResponse) {
            return $this->tableFromScalar($output, $apiResponse->response(), $filter);
        }

        return $this->tableFromArray($output, $decodedResponse);
    }

    private function tableFromScalar(OutputInterface $output, string $value, ?string $header = null): Table
    {
        $table = new Table($output);
        if ($header) {
            $table->setHeaders([$header]);
        } else {
            $table->setHeaders([self::UNKNOWN_HEADER]);
        }

        $rows[][] = str_replace("\n", '', $value);
        $table->setRows($rows);

        return $table;
    }

    private function tableFromArray(OutputInterface $output, array $tableElements): Table
    {
        $table = new Table($output);
        $headers = array_keys($tableElements);
        $table->setHeaders($headers);

        $rows[] = array_values($tableElements);
        $table->setRows($rows);

        return $table;
    }
}
