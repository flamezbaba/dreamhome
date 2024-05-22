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
use App\Models\Order;
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Models\Settings;
use App\Exceptions\MyException;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $latest_props = Property::where("status", "active")->orderBy("id", "DESC")->limit(5)->get();

        return Inertia::render('Home/Index', [
            'page_title' => 'Home',
            'types' => PropertyType::all(),
            'categories' => PropertyCategory::all(),
            'latest_properties' => $latest_props,
        ]);
    }

    public function about(Request $request)
    {
        // return Inertia::render('Home/About', [
        //     'page_title' => 'About Us',
        // ]);
    }

    public function contact(Request $request)
    {
        return Inertia::render('Home/Contact', [
            'page_title' => 'Contact Us',
        ]);
    }

    public function view_property($uuid, Request $request)
    {

        $property = Property::where("uuid", $uuid)->first();
        $others = Property::where("status", "active")->orderBy("id", "DESC")->limit(3)->get();

        if ($property) {

            if ($request->place_order == true) {
                $validator = Validator::make($request->all(), [
                    'property_id' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
                } else {
                    $user = Auth::guard("user")->user();

                    if ($user) {
                        $property = Property::find($request->property_id);
                        if ($property) {

                            $order = new Order();
                            $order->uuid = mt_rand(111_111_111, 999_999_999);
                            $order->user_id = $user->id;
                            $order->property_id = $property->id;
                            $order->currency = $property->currency->symbol;
                            $bonus = ($property->bonus / 100) * FilterService::filAmount($property->price);
                            $order->amount = FilterService::filAmount($property->price) - $bonus;
                            $order->save();

                            return redirect()->route("order.view", $order->uuid);
                        } else {
                            return redirect()
                                ->back()
                                ->with('poperror', 'Property Not Found');
                        }
                    } else {
                        return redirect()->route("login")->with("poperror", "Login your account");
                    }
                }
            }

            // // dd($property->images);
            // $kk = asset("s3/logo.png");
            // $kk = $property->images[0];
            // // dd(asset("s3/logo.png"));

            // echo "<img src='$kk' />";
            // exit();

            return Inertia::render('Home/Property', [
                'page_title' => $property->title,
                'property' => $property,
                'others' => $others,
            ]);
        } else {
            return redirect()->route("home");
        }
    }


    public function search(Request $request)
    {
        $keyword = urldecode($request->keyword);
        $type = urldecode($request->type);
        $category = urldecode($request->category);

        // dd($category);


        $properties = Property::where("category", "LIKE", "%$category%")
            // ->orWhere("description", "LIKE", "%$keyword%")
            ->where("type", "LIKE", "%$type%")
            ->where("title", "LIKE", "%$keyword%")
            ->orderBy("id", "DESC")
            ->paginate(10)
            ->withqueryString();
        // dd($properties);
        // exit();

        return Inertia::render('Home/Search', [
            'page_title' => 'Search',
            'types' => PropertyType::all(),
            'categories' => PropertyCategory::all(),
            'properties' => $properties,
            'keyword' => $keyword,
            'type' => $type,
            'category' => $category,
        ]);
    }

    public function post_search(Request $request)
    {

        if ($request->search_property == true) {
            $validator = Validator::make($request->all(), [
                'keyword' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
            } else {

                $q = [
                    'keyword' => urlencode($request->keyword),
                    'type' => urlencode($request->type),
                    'category' => urlencode($request->category),
                    'bedrooms' => $request->bedrooms,
                    'property_id' => $request->property_id,
                    'min_price' => $request->min_price,
                    'max_price' => $request->max_price,
                ];
                return redirect()
                    ->route("search", $q);
            }
        }
    }

    public function profile(Request $request)
    {
        $user = Auth::guard("user")->user();

        if ($user) {

            $favs = [];

            if ($request->get_favs == true) {
                $validator = Validator::make($request->all(), [
                    // 'favs' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
                } else {
                    $favs = Property::whereIn("uuid", $request->favs)->get();
                }
            }

            if ($request->update_profile == true) {
                $validator = Validator::make($request->all(), [
                    'fullname' => 'required',
                    'email' => 'required',
                    'mobile' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
                } else {
                    $user->fullname = $request->fullname;
                    $user->email = strtolower($request->email);
                    $user->mobile = $request->mobile;
                    $user->save();


                    return redirect()
                        ->back()
                        ->with('homesuccess', ['msg' => "Profile Updated", 'timer' => true]);
                }
            }

            if ($request->update_password == true) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
                } else {
                    $user->password = $request->password;
                    $user->save();


                    return redirect()
                        ->back()
                        ->with('homesuccess', ['msg' => "Password Updated", 'timer' => true]);
                }
            }

            return Inertia::render('Home/Profile', [
                'page_title' => 'Profile',
                'favs' => $favs,
                'user' => [
                    'fullname' => $user->fullname,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                ]
            ]);
        } else {
            return redirect()->route("home");
        }
    }

    public function order_view($uuid, Request $request)
    {
        $order = Order::where("uuid", $uuid)->first();
        $user = Auth::guard("user")->user();

        if ($user) {
            if ($order) {
                if ($request->upload_receipt == true) {
                    $validator = Validator::make($request->all(), [
                        'image' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return redirect()
                            ->back()
                            ->with('homeerror', ['msg' => $validator->messages()->first(), 'timer' => true]);
                    } else {
                        if ($request->hasFile('image')) {
                            $s = $request->image->store("orders");
                            $order->receipt = $s;
                            $order->save();

                            return redirect()
                                ->back()
                                ->with('homesuccess', ['msg' => "Receipt Uploaded", 'timer' => true]);
                        }
                    }
                }
                $settings = Settings::where('name', 'bank')->first();
                return Inertia::render('Home/Order', [
                    'page_title' => $order->property->title,
                    'order' => $order,
                    'bank' => $settings ? $settings->value_html : "",
                ]);
            } else {
                return redirect()->route("profile");
            }
        } else {
            return redirect()->route("home");
        }
    }
}
