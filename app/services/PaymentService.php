<?php


namespace App\services;

use App\Contracts\SubscriptionInterface;
use App\Models\Book;
use App\Models\Subscription;
use App\Repository\PaymentRepository;
use Stripe\Charge;
use Stripe\Stripe;

/**
 * Class PaymentService
 * @package App\sevices
 */
class PaymentService
{
    /**
     * @var PaymentRepository
     */
    private PaymentRepository $paymentRepository;

    private SubscriptionInterface $subRepository;

    /**
     * PaymentService constructor.
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository,
                                SubscriptionInterface $subRepository)
    {
        $this->subRepository = $subRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param array $chargeData
     * @return Charge
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function charge(array $chargeData): Charge
    {
        return Charge::create([
            "amount" => $chargeData['amount'] * 100,
            "currency" => "usd",
            "source" => $chargeData['stripeToken'],
            "description" => $chargeData['description'],
        ]);

    }


    /**
     * @param array $data
     * @return array
     *
     */

    public function createPayment(array $data, $type): array
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $charge = $this->charge($data['chargeData']);
            if ($type == Book::class) {

                $this->paymentRepository->store($data['paymentData']);

            } elseif ($type == Subscription::class) {
                $data['paymentData']['charge_id'] = $charge->id;
                $this->subRepository->store($data['paymentData']);
            }

            return [
                'success' => true,
                'type' => 'success',
                'charge' => $charge
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'type' => 'error',
                'message' => $exception->getMessage()
            ];
        }
    }


}
