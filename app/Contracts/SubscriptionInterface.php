<?php


namespace App\Contracts;


interface SubscriptionInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public  function store($data);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function userSub($id);

    /**
     * @return mixed
     */
    public function getByIdCansle($id,$cansle);
}
