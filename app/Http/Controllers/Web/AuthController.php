<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Carbon\CarbonImmutable;
use Carbon\Carbon;

use App\Services\FilterService;

use App\Models\Admin;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Exceptions\MyException;

class AuthController extends Controller
{

    public function __construct()
    {
    }

    public function login(Request $request)
    {

        if ($request->login_user == true) {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            // dd($request);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
            } else {

                $check = User::where("email", strtolower($request->email))->where("password", $request->password)->first();

                if ($check) {
                    Auth::guard("user")->login($check);
                    return redirect()
                        ->back();
                } else {
                    return redirect()
                        ->back()
                        ->with('homeerror', ['msg' => "invalid login details", 'timer' => true]);
                }
            }
        }


        if ($request->logout_user == true) {
            Auth::guard("user")->logout();

            return redirect()->back();
        }
    }

    public function register(Request $request)
    {

        if ($request->register_user == true) {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
            } else {

                $check = User::where("email", strtolower($request->email))->orWhere("mobile", $request->mobile)->first();

                if ($check) {
                    return redirect()
                        ->back()
                        ->with('homeerror', ['msg' => "Email or Phone Number already used", 'timer' => true]);
                }

                $user = new User();
                $user->fullname = strtolower($request->fullname);
                $user->email = strtolower($request->email);
                $user->mobile = $request->mobile;
                $user->password = $request->password;
                $user->save();

                Auth::guard("user")->login($user);

                return redirect()
                    ->back()
                    ->with('homesuccess', ['msg' => "Registration Successful", 'timer' => true]);
            }
        }
    }
}
