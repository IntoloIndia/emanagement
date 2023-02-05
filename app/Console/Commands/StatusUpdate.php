<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApplyOffer;
use Illuminate\Support\Carbon;
use App\MyApp;
// use Carbon\Carbon;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:statusupdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'offerstatusupdate';

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
     * @return int
     */
    public function handle()
    {
        // $currentDate = Carbon::now()->format('g:i A');

         $allOffers =  ApplyOffer::where('status',1)->get();
        foreach ($allOffers as $key => $offers) {
          $apply_offer_date =Carbon::parse($offers->offer_start_time);
            // $offer_end_date = $apply_offer_date->diffInDays($offers->offer_to);
            $offer_end_date = $apply_offer_date->diffInMinutes($offers->offer_end_time);
            if($offer_end_date > 0){
                ApplyOffer::where('id',$offers->id)->update(['status'=>0]);
            }
            \Log::info($offer_end_date);
        }
    }
}
