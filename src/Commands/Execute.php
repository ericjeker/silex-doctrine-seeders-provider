<?php

namespace Wowww\Silex\Provider\Commands;

use Silex\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Execute extends Command
{
    private $seederApplication;

    protected function configure()
    {
        $this
            ->setName('seeders:execute')
            ->setDescription('Execute the seeder.')
            ->addOption('class', 'c', InputOption::VALUE_OPTIONAL, 'The seeder class to execute', 'App\Seeders\DatabaseSeeder');
    }

    /**
     * @return mixed
     */
    public function getSeederApplication()
    {
        return $this->seederApplication;
    }

    public function setSeederApplication(Application $application)
    {
        $this->seederApplication = $application;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->getOption('class');

        $output->write("Running \"<comment>{$className}</comment>\"...");

        // if the return value is an array, they are considered as a list of seeders
        $class = new $className($this->getSeederApplication(), $output);
        $classes = $class->seed();

        $output->writeln(" Done.");

        if (is_array($classes)) {
            foreach ($classes as $className) {
                $output->write("Running \"<comment>{$className}</comment>\"...");

                $class = new $className($this->getSeederApplication(), $output);
                $class->seed();

                $output->writeln(" Done.");
            }
        }
    }
}