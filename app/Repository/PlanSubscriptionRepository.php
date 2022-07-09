<?php


namespace App\Repository;


use App\Contracts\PlanSubscriptionInterface;
use App\Models\Plan;

class PlanSubscriptionRepository implements PlanSubscriptionInterface
{
    /**
     * @var Plan
     */
    protected Plan $model;

    /**
     * PlanSubscriptionRepository constructor.
     * @param Plan $model
     */
    public function __construct(Plan $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model::where('id',$id)->first();
    }

}
