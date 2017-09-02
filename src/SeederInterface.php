<?php

namespace Wowww\Silex\Provider;

interface SeederInterface
{
    /**
     * @return mixed
     */
    public function seed();
}