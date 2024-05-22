<?php

namespace App\Http\Controllers\Web\Admin;

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

use App\Exceptions\MyException;

class UserController extends Controller
{
    private $admin;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->admin = Auth::guard('admin')->user();

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->delete_user == true) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $user = User::find($request->user_id);
                if ($user) {
                    $user->delete();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                } else {
                    return redirect()
                        ->back()
                        ->with('poperror', 'Record not found');
                }
            }
        }

        if ($request->ban_user == true) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $user = User::find($request->user_id);
                if ($user) {
                    if($user->is_blocked == 1){
                        $user->is_blocked = 0;
                    }
                    else{
                        $user->is_blocked = 1;
                    }
                    
                    $user->relogin = 1;
                    $user->save();


                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                } else {
                    return redirect()
                        ->back()
                        ->with('poperror', 'Record not found');
                }
            }
        }

        $records = User::orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate(20)
            ->withQueryString()
            ->through(
                fn ($record) => [
                    "id" => $record->id,
                    "fullname" => $record->fullname ?? '',
                    "email" => $record->email ?? '',
                    "mobile" => $record->mobile ?? '',
                    "status" => $record->is_blocked == 1 ? 'Blocked' : 'Active'
                ]
            );

        return Inertia::render('Admin/User/Index', [
            'page_title' => 'User List',
            'filters' => $request->all('search'),
            'records' => $records,
        ]);
    }
}
