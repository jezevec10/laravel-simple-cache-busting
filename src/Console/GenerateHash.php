<?php namespace Ruyter\CacheBusting\Console;

use CacheBusting;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateHash extends Command {

    protected $name = 'cachebusting:generate';
    protected $description = 'Generates a new asset hash';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $this->line('Generating new hash. Environment: <comment>'.$this->laravel->make('env').'</comment>');

        $hash = CacheBusting::replaceHash();

        $this->info("New hash {$hash} generated.");
    }
}
