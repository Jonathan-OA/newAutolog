<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ImportacaoTeste extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste agendador de tarefas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('importacao')->insert(['date_imp' => date('Y-m-d H:i:s'), 'obs1' => 'Teste']);
    }
}
