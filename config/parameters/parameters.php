<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $configurator) {
    $parameters = $configurator->parameters();
    $parameters->set('ip_info_base_url', '%env(IP_INFO_BASE_URL)%');
    $parameters->set('storage_base_path', '%env(STORAGE_BASE_PATH)%');
};