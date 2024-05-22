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
use Illuminate\Support\Str;
use Inertia\Inertia;
use Carbon\CarbonImmutable;
use Carbon\Carbon;

use App\Services\FilterService;

use App\Models\Settings;
use App\Exceptions\MyException;

class SettingsController extends Controller
{
    private $admin;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->admin = Auth::guard('admin')->user();

            return $next($request);
        });
    }

    public function bank(Request $request)
    {
        $settings = Settings::where('name', 'bank')->first();

        if ($request->edit_bank == true) {
            $validator = Validator::make($request->all(), [
                'bank_details' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {

                $settings->value = $request->bank_details;

                $settings->save();

                return redirect()
                    ->back()
                    ->with('popsuccess', 'Operation Successful');
            }
        }

        return Inertia::render('Admin/Settings/Bank', [
            'page_title' => 'Bank Settings',
            'settings' => $settings,
        ]);
    }
}
