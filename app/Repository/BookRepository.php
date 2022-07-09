<?php


namespace App\Repository;


use App\Contracts\BookInterface;
use App\Models\Book;

class BookRepository implements BookInterface
{
    protected Book $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return mixed
     */
public function createBook(array $data)
{

    return $this->model->create($data);
}

    /**
     * @param array $id
     * @return mixed
     */
    public function Bookid($id): mixed
    {
        return $this->model::where('id',$id)->first();
    }
//    public function Bookpayment(array $data): mixed
//    {
//        return $this->model::with([$data => function ($query) {
//            $query->where('user_id', auth()->id());
//        }])->get();
//    }

}
