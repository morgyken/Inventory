<?php

namespace Ignite\Inventory\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateStock extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'system:update-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs background housekeeping. Doing stock adjustments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $this->info('Updating stock');
        $this->call('queue:work', ['--queue' => 'stock']);
        $this->info('... Done');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return [
                //  ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
                // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
