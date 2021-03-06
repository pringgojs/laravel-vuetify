<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
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
        if (session('type')) {
            return redirect(session('type'));
        }
        
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
                'type' => $response->type,
                'username' => $request->input('username'),
                'name' => $response->data->nama,
                'id' => $response->data->nomor,
                'url' => url($response->type)
            ]
        );
    }

    public function logout()
    {
        \Session::forget('type');
        \Session::forget('username');
        \Session::forget('name');
        \Session::forget('id');

        return redirect('/login');
    }

    function checkAuth()
    {
        if (session('type')) {
            return redirect(session('type'));
        }

        return redirect('login');
    }

    public function resetPassword(Request $request)
    {
        $url = config('api.url').'/reset-password';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }
}
