<?php


namespace App\Contracts;


interface PaymentInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
}
