<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $url = config('api.url').'/login';
        $response = Curl::to($url)
            ->withData($request->toArray())
            ->post();
        $response = json_decode($response);
        
        if ($response->status == 0) {
            return response()->json(
                [
                    'status' => 0,
                ]
		    );
        }

        session(['type' => $response->type]);
        session(['username' => $request->input('username')]);
        session(['name' => $response->data->nama]);
        session(['id' => $response->data->nomor]);

        return response()->json(
            [
                'status' => 1,
                'url' => url($response->type)
            ]
        );
    }

    function checkAuth()
    {
        if (session('type')) {
            return redirect(session('type'));
        }

        return redirect('login');
    }
}
