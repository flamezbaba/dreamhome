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


use App\Services\FilterService;

use App\Models\Settings;
use App\Models\Agent;
use App\Exceptions\MyException;

class AgentController extends Controller
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
        if ($request->create_agent == true) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {

                $check_email = Agent::where("email", strtolower($request->email))->where("mobile", strtolower($request->mobile))->first();
                if ($check_email) {
                    return redirect()
                        ->back()
                        ->with('poperror', 'Email or Mobile Already Used');
                }

                $agent = new Agent();
                $agent->name = strtolower($request->name);
                $agent->email = strtolower($request->email);
                $agent->mobile = $request->mobile;
                $agent->uuid = mt_rand(111_111, 999_999);
                $agent->save();

                return redirect()
                    ->back()
                    ->with('popsuccess', 'Operation Successful');
            }
        }

        if ($request->edit_agent == true) {
            $validator = Validator::make($request->all(), [
                'agent_id' => 'required',
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $agent = Agent::find($request->agent_id);

                if ($agent) {

                    $check = Agent::where("email", strtolower($request->email))->where("id", "!=", $agent->id)->first();
                    if ($check) {
                        return redirect()
                            ->back()
                            ->with('poperror', 'Email Already Used');
                    }

                    $check = Agent::where("mobile", $request->mobile)->where("id", "!=", $agent->id)->first();
                    if ($check) {
                        return redirect()
                            ->back()
                            ->with('poperror', 'Mobile Already Used');
                    }

                    $agent->name = strtolower($request->name);
                    $agent->email = strtolower($request->email);
                    $agent->mobile = $request->mobile;
                    $agent->save();
                }

                return redirect()
                    ->back()
                    ->with('poperror', 'Agent Not Found');
            }
        }

        if ($request->delete_agent == true) {
            $validator = Validator::make($request->all(), [
                'agent_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $agent = Agent::find($request->agent_id);

                if ($agent) {
                    $agent->delete();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                }

                return redirect()
                    ->back()
                    ->with('poperror', 'Agent Not Found');
            }
        }

        $agents = Agent::orderBy("id", "desc")->get();

        return Inertia::render('Admin/Property/Agents', [
            'page_title' => 'Agents',
            'settings' => $agents,
        ]);
    }
}
