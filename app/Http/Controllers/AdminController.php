<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Contracts\UserInterface;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * @var UserInterface
     */
    protected UserInterface $userRepo;

    /**
     * UserController constructor.
     * @param UserInterface $userRepo
     */
    public function __construct(Userinterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

            $users = User::all();
            return view('pages.admin', compact('users'));


    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $this->userRepo->delete($id);
        return redirect()->back();
    }
}
