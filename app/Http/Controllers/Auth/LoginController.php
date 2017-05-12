<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // don't forget to import the namespace

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';
    protected $redirectAfterLogout = '/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    // add this logout method
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect($this->redirectAfterLogout);
    }
}