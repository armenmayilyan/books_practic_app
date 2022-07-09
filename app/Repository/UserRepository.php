<?php


namespace App\Repository;



use App\Contracts\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository implements UserInterface
{
    /**
     * @var User
     */
    protected User $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
       return $this->model->create($data);
    }

    /**
     * @param mixed $email
     * @return mixed
     */
    public function Emailcheck(mixed $email){

        return $this->model::where('email',$email)->whereNotNull('email_verified_at')->first();
    }

    /**
     * @param mixed $id
     * @return Model
     */
    public function updateEmail(mixed $id)
    {
        return $this->model::where($id)->update(['email_verified_at' => today()]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function github(array $data)
    {

        return $this->model::create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function githubid(array $data){

        return $this->model::where('git_id', $data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function delete($data){

        return $this->model::where('id', $data)->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUser($id){

        return $this->model::where('id', $id)->first();
    }
}
