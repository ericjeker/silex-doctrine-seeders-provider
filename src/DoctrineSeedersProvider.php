<?php

namespace Wowww\Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\Console\Application as Console;
use Wowww\Silex\Provider\Commands\Execute;

class DoctrineSeedersProvider implements
    ServiceProviderInterface,
    BootableProviderInterface
{
    /**
     * The console application.
     *
     * @var Console
     */
    protected $console;

    /**
     * Creates a new doctrine seeders provider.
     *
     * @param Console $console
     */
    public function __construct(Console $console = null)
    {
        $this->console = $console;
    }

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $app A container instance
     */
    public function register(Container $app)
    {
        $app['seeders.commands'] = function (Container $app) {
            $commands = [];

            foreach ($app['seeders.command_names'] as $name) {
                $command = new $name();
                $command->setSeederApplication($app);
                $commands[] = $command;
            }

            return $commands;
        };

        $app['seeders.command_names'] = function (Container $app) {
            $commands = [
                Execute::class
            ];

            return $commands;
        };

    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app A Silex application instance
     */
    public function boot(Application $app)
    {
        $console = $this->getConsole($app);

        if ($console) {
            $console->addCommands($app['seeders.commands']);
        }
    }

    /**
     * Gets the console application.
     *
     * @param Container $app
     * @return Console|null
     */
    public function getConsole(Container $app = null)
    {
        return $this->console ?: (isset($app['console']) ? $app['console'] : new Console());
    }
}