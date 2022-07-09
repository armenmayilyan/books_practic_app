<?php


namespace App\Contracts;


interface PaymentInterface
{

    public function store(array $data);
}
