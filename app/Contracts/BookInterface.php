<?php


namespace App\Contracts;

interface BookInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createBook(array $data);

    /**
     * @param array $id
     * @return mixed
     */
    public function BookByid(array $id);

}
