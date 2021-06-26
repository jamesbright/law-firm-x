<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\SendMailJob;
use App\Client;
use App\Mail\SetImage;

class NotifyClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an update profile image notification to clients';


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
             $details = [
        'title' => 'Update profile image',
        'body' => 'Please be kindly reminded that you are yet to set your profile picture.'
    ];
                    $clients = Client::where('email','jamesononiwu@gmail.com')->get();
                    foreach($clients as $client) {
                        dispatch(new SendMailJob(
                            $client->email, 
                            new SetImage($details))
                        );
                    }
               
        }
    
}