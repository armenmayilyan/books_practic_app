<?php


namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BookInterface
{
    public function createBook(array $data);

    public function Bookid(array $id);

}
