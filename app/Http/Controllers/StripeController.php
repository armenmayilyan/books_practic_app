<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\sevices\PaymentService;
use Illuminate\Http\Request;
use Stripe;
use App\Contracts\BookInterface;
use App\Contracts\PaymentInterface;

class StripeController extends Controller
{

    /**
     * @var BookInterface
     */
    protected BookInterface $bookRepo;
    /**
     * @var PaymentInterface
     */
    protected PaymentInterface $paymentrepo;
    private PaymentService $paymentService;

    /**
     * StripeController constructor.
     * @param BookInterface $bookRepo
     * @param PaymentService $paymentService
     * @param PaymentInterface $paymentrepo
     */
    public function __construct(Bookinterface $bookRepo,
                                PaymentService $paymentService,
                                PaymentInterface $paymentrepo)
    {
        $this->bookRepo = $bookRepo;
        $this->paymentrepo = $paymentrepo;
        $this->paymentService = $paymentService;
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($id)
    {
        $books = $this->bookRepo->Bookid($id);
        return view('pages.stripe', compact('books'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request, $id)
    {
        $books = $this->bookRepo->Bookid($id);
        $paymentData = [
            'chargeData' => [
                'stripeToken' => $request->stripeToken,
                'amount' => $books->price,
                'description' => "This payment is tested purpose" . '  ' . $books->name
            ],
            'paymentData' => [
                'user_id' => auth()->id(),
                'paymantable_type' => Book::class,
                'amount' => $books->price,
                'paymantable_id' => $books->id,
            ]
        ];
        $paymentResponse = $this->paymentService->createPayment($paymentData,Book::class);

        return redirect('books');

    }
}
