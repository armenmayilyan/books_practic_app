<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\services\PaymentService;
use Illuminate\Http\Request;
use App\Contracts\BookInterface;
use App\Contracts\PaymentInterface;

class StripeController extends Controller
{

    public function __construct(protected Bookinterface $bookRepo,
                                protected PaymentService $paymentService,
                                protected PaymentInterface $paymentrepo)
    {}

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function stripe($id)
    {
        $book = $this->bookRepo->BookByid($id);

        return view('pages.stripe', compact('book'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request, $id)
    {

        $books = $this->bookRepo->BookByid($id);

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

         $this->paymentService->createPayment($paymentData,Book::class);

        return redirect('books');

    }
}
