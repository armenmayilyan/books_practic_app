<?php


namespace App\Repository;

use App\Contracts\PaymentInterface;
use App\Models\Payment;

class PaymentRepository implements PaymentInterface
{
    protected Payment $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
    public function store(array $data)
    {
        return $this->model->create($data);
    }
}
