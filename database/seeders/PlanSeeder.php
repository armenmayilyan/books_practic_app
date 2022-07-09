<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $free =  $stripe->products->create([
            'name' => 'free',
        ]);
        $free_plan = $stripe->plans->create([
            'amount' => 0,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => $free->id,
        ]);
        $standart =  $stripe->products->create([
            'name' => 'standart',
        ]);

        $standard_plan = $stripe->plans->create([
            'amount' => 10,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => $standart->id,
        ]);
        $premium =  $stripe->products->create([
            'name' => 'premium',
        ]);
        $premium_plan = $stripe->plans->create([
            'amount' => 50,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => $premium->id,
        ]);

        DB::table('plans')->insert([

            [
                'name' => 'free',
                'price' => 0,
                'period' => 'monthly',
                'limit' => 5,
                'plan_id' => $standard_plan->id,
            ],

            [
                'name' => 'Standard',
                'price' => 15,
                'period' => 'monthly',
                'limit' => 10,
                'plan_id' => $standard_plan->id,
            ],
            [
                'name' => 'Premium',
                'price' => 25,
                'period' => 'monthly',
                'limit' => 15,
                'plan_id' => $premium_plan->id,
            ],

        ]);

    }
}
