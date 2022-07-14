<?php


namespace App\Repository;


use App\Contracts\BookInterface;
use App\Models\Book;

class BookRepository implements BookInterface
{
    /**
     * @var Book
     */
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
    public function BookBYid($id): mixed
    {
        return $this->model::where('id',$id)->first();
    }


}
