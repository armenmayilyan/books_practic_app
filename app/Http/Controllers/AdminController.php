<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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


    public function index()
    {

            $users = User::all();
            return view('pages.admin', compact('users'));


    }
    public function delete(Request $request, $id)
    {
        $this->userRepo->delete($id);
        return redirect()->back();
    }
}
