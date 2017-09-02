<?php

namespace Wowww\Silex\Provider;

use Silex\Application;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractSeeder
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var OutputInterface
     */
    protected $output;

    public function __construct(Application $app, OutputInterface $output)
    {
        $this->app = $app;
        $this->output = $output;
    }

    abstract public function seed();
}