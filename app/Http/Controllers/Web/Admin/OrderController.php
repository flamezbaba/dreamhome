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

use App\Http\Resources\InvestmentResources;

use App\Services\FilterService;

use App\Models\Admin;
use App\Models\User;
use App\Models\Property;
use App\Models\Order;
use App\Models\PropertyCategory;
use App\Exceptions\MyException;

class OrderController extends Controller
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

        $records = Order::orderBy('id', 'desc')->get();
        // dd($records);

        if ($request->toggle_paid == true) {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $order = Order::find($request->order_id);
                if ($order) {
                    if ($order->is_paid == 0) {
                        $order->is_paid = 1;
                    } else {
                        $order->is_paid = 0;
                    }

                    $order->save();

                    return redirect()
                        ->back()
                        ->with('popsuccess', "Done");
                }
            }
        }

        $rr = $records->filter(function ($r) {
            return $r->property;
        });

        return Inertia::render('Admin/Order/Index', [
            'page_title' => 'Orders',
            'records' => $rr
        ]);
    }
}
