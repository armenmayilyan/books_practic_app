<?php


namespace App\Contracts;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface UserInterface
 * @package App\Contracts
 */
interface UserInterface
{

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): mixed;

    /**
     * @param mixed $id
     * @return mixed
     */

    public function updateEmail(mixed $id);

    /**
     * @param mixed $email
     * @return mixed
     */
    public function Emailcheck(mixed $email);

    /**
     * @param array $data
     * @return mixed
     */
    public function github(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function githubid(array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function getUser($id);

    /**
     * @param array $data
     * @return mixed
     */
    public function delete($data);


}
