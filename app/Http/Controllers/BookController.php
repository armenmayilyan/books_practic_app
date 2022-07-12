<?php

namespace App\Http\Controllers;

use App\Contracts\BookInterface;
use App\Contracts\SubscriptionInterface;
use App\Http\Requests\CreateRequest;
use App\Models\Book;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BookController extends Controller
{
    /**
     * BookController constructor.
     * @param BookInterface $bookRepo
     * @param SubscriptionInterface $subRepo
     */
    public function __construct(protected BookInterface $bookRepo,
                                protected SubscriptionInterface $subRepo)
    {}

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
            $active = auth()->user()->activeSubscription();
            if ($active && auth()->user()->books()->count() < $active->limit) {
                return view('pages.create', compact( 'active'));
            } else {
                return redirect()->back();
            }

        }



    public function books()
    {
        $books = Book::with(['payments' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return view('pages.books', compact('books',));
    }

    public function getDownload($id)
    {
        $book = $this->bookRepo->Bookid($id);
        return response()->download($book->file);

    }

    /**
     * @param CreateRequest $createRequest
     * @return mixed
     */
    public function createBook(CreateRequest $createRequest)
    {
        $image = Storage::putFile('public/photos', $createRequest->file('bookFile'));
        $image = Str::replaceFirst('public', 'storage', $image);
        $bookpdf = Storage::putFile('public/pdfFile', $createRequest->file('bookpdf'));
        $bookpdf = Str::replaceFirst('public', 'storage', $bookpdf);
        $data = [
            'name' => $createRequest->input('name'),
            'description' => $createRequest->input('description'),
            'price' => $createRequest->input('price'),
            'image' => $image,
            'file' => $bookpdf,
            'user_id' => auth()->id(),
            'count' => count(Book::all())
        ];
        $book = $this->bookRepo->createBook($data);
        return redirect(route('books',));
    }

}
