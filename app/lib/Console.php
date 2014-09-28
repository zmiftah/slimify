<?php

namespace App\Lib;

use Commando\Command;

class Console
{
    private $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    public function run() {}
}