<?php

namespace App\Http\Controllers;

use App\Contracts\PlanSubscriptionInterface;
use App\Contracts\SubscriptionInterface;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\sevices\PaymentService;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    /**
     * SubscriptionController constructor.
     * @param PlanSubscriptionInterface $planRepo
     * @param PaymentService $paymentService
     * @param SubscriptionInterface $subRepo
     */
    public function __construct(
        protected PlanSubscriptionInterface $planRepo,
        protected PaymentService $paymentService,
        protected SubscriptionInterface $subRepo
    ){}

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $plans = Plan::get();
        $active = auth()->user()->activeSubscription();

        $subscriptions = $this->subRepo->userSub(\Auth::id());

        return view('pages.subscription', compact('plans', 'active'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function cancel($id)
    {
        $subscription = $this->subRepo->getById($id);
        $date = carbon::now();
        $cancel = [
            'active' => false,
            'cancle_sub' => $date->toDateString(),
        ];
        $this->subRepo->getByIdCansle($id, $cancel);
        if($subscription->amount == 0) {
            $this->subRepo->getByIdCansle($id, $cancel);
            return redirect()->back();

        };
        $usePeriod = Carbon::now()->diffInDays($subscription->created_at);
        $usePeriodAmount = $subscription->amount/30 * $usePeriod;
        $refundAmount = ($subscription->amount - $usePeriodAmount) * 100;
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $stripe->refunds->create([
            'charge' => Subscription::query()->where('id', $id)->first()->charge_id,
            'amount' => $refundAmount
        ]);



        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $plan = $this->planRepo->getById($request->plan_id);

        $paymentData = [
            'chargeData' => [
                'stripeToken' => $request->stripeToken,
                'amount' => $plan->price,
                'description' => "This subscription is amount" . '  ' . $plan->name,
                'end_date' => Carbon::now()->addMonth()
            ],

            'paymentData' => [
                'user_id' => auth()->id(),
                'limit' => $plan['limit'],
                'amount' => $plan['price'],
                'type' => Subscription::class,
                'plan_id' => $plan['id'],
                'active' => 1,
                'end_date' => Carbon::now()->addMonth()
            ]
        ];
        if($paymentData['paymentData']['amount'] == 0){
            $paymentData['paymentData']['charge_id'] = $plan->name;

            $this->subRepo->store($paymentData['paymentData']);
            return redirect()->back();
        }
        $this->paymentService->createPayment($paymentData, Subscription::class);
        return redirect()->to(route('subscriptions', compact('plan',)));
    }

}
