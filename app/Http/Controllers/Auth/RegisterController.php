<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Setting;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $setting = Setting::first();
        return view('auth.register', ['setting' => $setting]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik' => ['required', 'integer', 'digits_between:3,30'],
            'name' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'digits_between:3,20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $update = User::find($data['id'])->update([
            'nik' => $data['nik'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if ($update) {
            return User::find($data['id']);
        } else {
            return false;
        }
    }

    public function register(Request $request)
    {
        $member = User::where('member_id', $request->member_id)->first();
        $this->validator($request->all())->validate();
        if (!is_null($member)) {
            $email_format = Setting::first();
            $email_input = $request->email;
            $cut = explode('@', $email_input);
            if (strtolower($cut[1]) == strtolower($email_format->type_email)) {
                if (ucWords($member->name) == ucWords($request->name) && ucWords($member->nik) == ucWords($request->nik)) {
                    event(new Registered($user = $this->create(array_merge($request->all(), ['id' => $member->id]))));
                    if ($user) {
                        $this->guard()->login($user);
                    }

                    if ($response = $this->registered($request, $user)) {
                        return $response;
                    }
                    return $request->wantsJson()
                        ? new JsonResponse([], 201)
                        : redirect($this->redirectPath());
                } else {
                    return redirect()->route('register')->with('error', 'Can\'t activate the account, you are not registered as a member of the community  ');
                }
            }else{
                return redirect()->route('register')->with('error', 'Can\'t activate the account, you are email extension is not supported  ');
            }
        } else {
            return redirect()->route('register')->with('error', 'Can\'t activate the account, you are not registered as a member of the community  ');
        }
    }
}