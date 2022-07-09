<?php


namespace App\Repository;


use App\Contracts\ResetPasswordInterface;
use App\Models\password_reset;

class ResetPasswordRepository implements ResetPasswordInterface
{
    /**
     * @var password_reset
     */
    protected password_reset $model;

    /**
     * ResetPasswordRepository constructor.
     * @param password_reset $model
     */
    public function __construct(password_reset $model)
    {

        $this -> model = $model;

    }
    public function createPassword($data)
    {
        return $this->model->create($data);
    }
}
