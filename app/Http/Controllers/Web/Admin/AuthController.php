<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

use App\Models\Admin;
use App\Models\User;
use App\Models\Site;

use App\Mail\WordMail;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        if ($request->has('login')) {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);

            $admin = Admin::where('email', $request->email)->first();

            if ($admin) {
                if ($request->password == $admin->password) {
                    Auth::guard('admin')->login($admin);
                    $admin->last_login = now();
                    $admin->ip_address = $request->ip();
                    $admin->meta_data = $request->server('HTTP_USER_AGENT');
                    $admin->save();

                    // dd("got here");

                    return redirect()
                    ->intended(route('admin.property'))
                    ->with(
                        'popsuccess',
                        "Welcome Back"
                    );
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Wrong Password');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Invalid Login Details');
            }
        }

        Auth::guard('admin')->logout();

        return Inertia::render('Admin/Auth/Login', [
            'page_title' => 'Admin Login',
        ]);
    }

    public function testing(Request $request)
    {
        $user = User::find(4);
        $ss = env("SITE_NAME");
        // $mail = new WordMail("register", "Welcome to $ss", $user, []);
        $msg = "<p>Firstname: iuu</p>";
        $mail = new WordMail("word", "Welcome to $ss", null, $msg);
        echo $mail->render();
        // Site::send_mail($mail->render(), $user->email, "Welcome to $ss");
        // echo "done";
    }
}
