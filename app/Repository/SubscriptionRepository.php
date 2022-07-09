<?php


namespace App\Repository;
use App\Contracts\SubscriptionInterface;
use App\Models\Subscription;

class SubscriptionRepository implements SubscriptionInterface
{
    protected Subscription $model;

public function __construct(Subscription $model)
{
     $this -> model = $model;
}

    public  function store($data)
    {
            return $this->model->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id){

        return $this->model::where('id',$id)->first();

    }

    /**
     * @param $id
     * @return mixed
     */
    public function userSub($id){

    return $this->model::where('user_id', $id)->get();
    }

    /**
     * @return mixed|void
     */
    public function getByIdCansle($id, $cansle){
     return $this->model::where('id',$id)->update($cansle);
    }

}
