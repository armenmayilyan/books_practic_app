<?php

namespace App\Http\Controllers;
use App\Contracts\UserInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\Mailverify;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param UserInterface $userRepo
     */
    public function __construct(
        protected Userinterface $userRepo)
    {}

    /**
     * @return Application|Factory|View
     */
    public function register()
    {

        return view('pages.register');

    }

    /**
     * @return Application|Factory|View
     */
    public function login()
    {
        return view('pages.login');
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeRegister(RegisterRequest $registerRequest)
    {

        $data = [
            'name' => $registerRequest->input('name'),
            'email' => $registerRequest->input('email'),
            'password' => Hash::make($registerRequest->input('password'))
        ];


        $user = $this->userRepo->store($data);
        Mail::to($user->email)->send(new Mailverify($user));

        return redirect('login');
    }

    /**
     * @return Application|Factory|View
     */
    public function reset()
    {

        return view('pages.reset');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {

        $user = $this->userRepo->emailCheck($request->email);

        if (!$user) {
            return redirect()->back()->with(['error' => 'Email not exists']);
        } else {
            $request->validate(['email' => 'required|email']);
            $status = Password::sendResetLink(
                $request->all('email')
            );
            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);

        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendPasswordResetNotification(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * @param LoginRequest $loginrequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLogin(LoginRequest $loginrequest)
    {
        $user = $this->userRepo->emailCheck($loginrequest->loginEmail);
        if ($user && Auth::attempt(['email' => $loginrequest->loginEmail, 'password' => $loginrequest->loginPassword])) {
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }

    }

    /**
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    /**
     * @param $id
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyEmail($id)
    {
        $user = $this->userRepo->updateEmail($id);

        if ($user) {
            return redirect(route('login'));
        } else {
            return redirect()->back();
        }

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function gitRedirect()
    {
        return Socialite::driver('github')->redirect();


    }

    /**
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function gitCallback()
    {

        $user = Socialite::driver('github')->user();

        $data = [
            $user->id
        ];
        $isUser = $this->userRepo->gitHubid($data);
        if ($isUser) {
            Auth::login($isUser);

            return redirect()->route('home');

        } else {
            $data = [
                'name' => $user->nickname,
                'email' => $user->email,
                'git_id' => $user->id,
            ];
             $createUser = $this->userRepo->github($data);

            Auth::login($createUser);

            return redirect(route('home'));
        }

    }
}

