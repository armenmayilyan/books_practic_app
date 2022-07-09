<?php

namespace App\Console\Commands;

use App\Contracts\SubscriptionInterface;
use App\Contracts\UserInterface;
use App\Models\Book;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Exception;
use Stripe\Charge;


class subscriptionDate extends Command
{
    private SubscriptionInterface $subRepo;
    private UserInterface $userRepo;


    public function __construct(SubscriptionInterface $subRepo,
                                UserInterface $userRepo)
    {
        parent::__construct();
        $this->subRepo = $subRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $date = Carbon::today();
            $subscriptions = Subscription::wheredate('end_date', $date->format('Y-m-d'))->get();
            foreach ($subscriptions as $subscriber) {
                $subscriber->active = false;
                $subscriber->save();
                $stripe = new \Stripe\StripeClient('sk_test_51LAVVYJpHB8lQVV6I6sqFQxovdA0GpBEXyFAX0d6ZDN7cKcL9elTsqnwDgIWC5w6qw58ArAHok4BW7lh94WpXx9U00XsgK8Bh7');

                $user = $this->userRepo->getUser(['id' => $subscriber->user_id]);
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

}

