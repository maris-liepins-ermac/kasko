<?php

use App\IpInfo\Infrastructure\Console\RequestIpInfoData;
use App\IpInfo\Infrastructure\Console\Service\FormatApiResponseService;
use App\IpInfo\Infrastructure\Storage\StorageInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $configurator) {

    $services = $configurator->services();

    $services->set(RequestIpInfoData::class)
        ->args(
            [
                service('app.api_client'),
                service(FormatApiResponseService::class),
                service(StorageInterface::class)
            ]
        )
        ->tag('console.command');
};