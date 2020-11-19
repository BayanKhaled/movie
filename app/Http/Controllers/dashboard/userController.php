<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Mail;
use Carbon\Carbon;

class userController extends Controller
{
    //
    public function __construct()
    {

        $this->middleware('guest:web')->except('logout');

    }

    public function showLoginForm()
    {

        return view('dashboard.login');

    }


    
    public function login(Request $request)
    {

        // Validate form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // Attempt to log the user in
        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect('/');
        }

        // if unsuccessful
        return redirect()->back()->withInput($request->only('email','remember'));

    }


    // =================================================================================================
    // =================================================================================================

    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        $request['password'] = Hash::make($request->password);

        Admins::create($request->all());


        return redirect()->intended(route('control.index'));
    }

    // =================================================================================================
    // =================================================================================================

    public function forget_passowrd()
    {
        return view('control.forget_password');
    }

    public function forget_passowrd_post(Request $request)
    {
        $admin = Admin::Where('email', request('email'))->first();
        if (!empty($admin)){
            
            $token = app('auth.password.broker')->createToken($admin);
            $data = DB::table('password_resets')->insert([
                'email'  => $admin->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            session()->flash('success','The Link was sent to your email.');
            Mail::to($admin->email)->send(new AdminResetPassword(['data' => $admin,'token' => $token]));
            return back();
        }
        session()->flash('fail','The email doesn\'t exist.');
        return back();        
    }
    // =================================================================================================
    // =================================================================================================

    public function recover_password($token)
    {
        $check_token = DB::table('password_resets')->where('token',$token)->where('created_at', '>', Carbon::now()->subHours(2))->first();
        if (! empty($check_token)){
            return view('control.recover_password', ['data', $check_token]);
        }else{
            return redirect()->guest(route('control.forget_passowrd'));
        }
    }

    public function recover_password_post($token)
    {
        /*echo request()->token;
        echo "<br>";
        echo request()->password;
        echo "<br>";
        echo request()->repassword;
        dd(request());*/
        $this->validate(request(), [
            'password' => ['required', 'required_with:password_confirmation','same:password_confirmation', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:6'],
        ]);


        $check_token = DB::table('password_resets')->where('token',$token)->where('created_at', '>', Carbon::now()->subHours(2))->first();
        //dd($check_token);
        if (! empty($check_token)){
            $admin = Admin::Where('email', $check_token->email)->update([
                    'email'=> $check_token->email,
                    'password' => Hash::make(request()->password), 
                ]);
            DB::table('password_resets')->where('email', request('email'))->delete();
            Auth::guard('admins')->attempt(['email' => $check_token->email, 'password' => request()->password], true);
            return redirect()->intended(route('control.dashboard'));
        }else {
            return redirect()->guest(route('control.forget_passowrd'));
        }
        
    }

    // =================================================================================================
    // =================================================================================================

    public function logout()
    {
        Auth::guard('admins')->logout();
        return redirect()->guest(route('control.login'));
    }

    // =================================================================================================
    // =================================================================================================
}
