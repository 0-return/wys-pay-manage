<?php

namespace App\Console\Commands;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RealTimeQueryFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'flow';

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
        $id = Cache::get('RealTimeQueryFlowLastId')??0;
        $orders =  Order::whereRaw("id > {$id}")->orderBy('created_at','desc')->first(['out_trade_no','trade_no','receipt_amount','pay_time']);
        if($orders->count()){
           $orders = $orders->toArray();
            $this->curl($orders);
           Cache::put('RealTimeQueryFlowLastId',$orders[0]['id'], 3600*24*365*100);
        }
    }

    /**
     *
     * @param $data
     */
    public function curl($data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.mohuibao.com/pay_youbao_pay");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS , http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    }

}
