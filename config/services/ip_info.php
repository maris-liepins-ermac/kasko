<?php

use App\IpInfo\Infrastructure\Api\ApiClient;
use App\IpInfo\Infrastructure\Console\Service\FormatApiResponseService;
use App\IpInfo\Infrastructure\Console\Service\ResponseRepresentationService;
use App\IpInfo\Infrastructure\HttpClient\HttpClient;
use App\IpInfo\Infrastructure\HttpClient\HttpClientFactory;
use App\IpInfo\Infrastructure\Storage\Filesystem\Service\ValidateFilePathService;
use App\IpInfo\Infrastructure\Storage\Filesystem\Service\WriteToFileService;
use App\IpInfo\Infrastructure\Storage\Filesystem\Storage;
use App\IpInfo\Infrastructure\Storage\StorageInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Filesystem\Filesystem;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $configurator) {
    $services = $configurator->services()->defaults()->autowire(true);

    $services
        ->set(HttpClientFactory::class)
        ->args(['%ip_info_base_url%']);;

    $services
        ->set('app.http_client', HttpClient::class)
        ->factory([service(HttpClientFactory::class), 'getClient']);

    $services
        ->set('app.api_client', ApiClient::class)
        ->args([service('app.http_client')]);

    $services
        ->set(ValidateFilePathService::class)
        ->args([service(Filesystem::class)]);

    $services
        ->set(WriteToFileService::class)
        ->args([service(Filesystem::class)]);

    $services
        ->set(Storage::class)
        ->args(
            [
                '%storage_base_path%',
                service(ValidateFilePathService::class),
                service(WriteToFileService::class)
            ]
        );

    $services->alias(StorageInterface::class, Storage::class);

    $services
        ->set(FormatApiResponseService::class);
};