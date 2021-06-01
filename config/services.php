<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void
{
    $parametersConfigs = new DirectoryIterator(__DIR__.'/parameters');
    foreach($parametersConfigs as $parametersConfig)
    {
        if($parametersConfig->isDot()){
            continue;
        }
        $configurator->import(__DIR__.'/parameters/'.$parametersConfig->getFilename());
    }

    $servicesConfig = new DirectoryIterator(__DIR__.'/services');
    foreach($servicesConfig as $serviceConfig)
    {
        if($serviceConfig->isDot()){
            continue;
        }
        $configurator->import(__DIR__.'/services/'.$serviceConfig->getFilename());
    }

    $commandsConfigs = new DirectoryIterator(__DIR__.'/commands');
    foreach($commandsConfigs as $commandsConfig)
    {
        if($commandsConfig->isDot()){
            continue;
        }
        $configurator->import(__DIR__.'/commands/'.$commandsConfig->getFilename());
    }
};