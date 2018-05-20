<?php

namespace App\Console\Commands;

use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SummTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:summ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create transactions file of previous day';

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
     * @throws \Exception
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function handle()
    {
        $transactionsSum = Transaction::whereBetween( 'created_at',[
            date('Y-m-d 00:00:00', strtotime('- 1 days')),
            date('Y-m-d 23:59:59', strtotime('- 1 days')),
        ])->sum('amount');

        $total = DB::table('transactions_total')->insert(  [
            'amount' => $transactionsSum,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if(!$total){
            throw new \Exception('Couldnt save Total transactions');
        }

        $this->output->text('Transactions success saved, ' . date('Y-m-d H:i:s'));
    }
}
