# silex-doctrine-seeders-provider

Provider to allow seeders in your Silex project.

## Installation

    // create the console application
    $console = new Application();

    // register doctrine DBAL seeder service provider
    $app->register(new DoctrineSeedersProvider($console), [
        'seeders.directory' => __DIR__ . '/database/seeders',
        'seeders.name' => 'App Seeder',
        'seeders.namespace' => 'App\Seeders'
    ]);

    $console->run();`

## Create a seeder class

    <?php

    namespace App\Seeders;

    use Wowww\Silex\Provider\AbstractSeeder;

    class UserSeeder extends AbstractSeeder
    {
        public function seed()
        {
             // ...
             // you can access app with $this->app

             // if your seeder return an array it is considered as sub-seeders
             return [
                 ArticleSeeder::class,
                 RegistrationsSeeder::class
             ];
        }
    }

## Run the seeders

    php console.php seeders:execute

