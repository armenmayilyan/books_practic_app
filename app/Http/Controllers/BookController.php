<?php

namespace App\Http\Controllers;
use App\Contracts\BookInterface;
use App\Contracts\SubscriptionInterface;
use App\Http\Requests\CreateRequest;
use App\Models\Book;
use App\services\FileService;


class BookController extends Controller
{
    /**
     * BookController constructor.
     * @param BookInterface $bookRepo
     * @param SubscriptionInterface $subRepo
     * @param FileService $fileService
     */
    public function __construct(
        protected BookInterface $bookRepo,
        protected SubscriptionInterface $subRepo,
        protected FileService $fileService
    )
    {}

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $active = auth()->user()->activeSubscription();
        if ($active && auth()->user()->books()->count() < $active->limit) {
            return view('pages.create', compact('active'));
        } else {
            return redirect()->back();
        }

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function books()
    {
        $books = Book::with(['payments' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return view('pages.books', compact('books',));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getDownload($id)
    {
        $book = $this->bookRepo->BookByid($id);
        return response()->download($book->file);

    }

    /**
     * @param CreateRequest $createRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createBook(CreateRequest $createRequest)
    {

       $response= $this->fileService->file($createRequest->file());

        $data = [
            'name' => $createRequest->input('name'),
            'description' => $createRequest->input('description'),
            'price' => $createRequest->input('price'),
            'image' => $response['image'],
            'file' => $response['bookPdf'],
            'user_id' => auth()->id(),
        ];
        $this->bookRepo->createBook($data);
        return redirect(route('books',));
    }

}
