<?php

namespace Fesor\RequestObject\Examples\App;

use Fesor\RequestObject\Bundle\RequestObjectBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new RequestObjectBundle(),
        ];
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', array(
            'secret' => 'S0ME_SECRET',
            'session' => [
                'storage_id' => 'session.storage.mock_file'
            ],
            'validation' => [
                'enabled' => true
            ],
        ));

        $c->register('app_controller', AppController::class);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/users', 'app_controller:registerUserAction');
        $routes->add('/users_extended', 'app_controller:registerUserCustomAction');
        $routes->add('/error_response', 'app_controller:withErrorResponseAction');
        $routes->add('/context_depending', 'app_controller:contextDependingRequestAction');
        $routes->add('/no_request', 'app_controller:noCustomRequestAction');
        $routes->add('/validation_results', 'app_controller:validationResultsAction');
    }
}
