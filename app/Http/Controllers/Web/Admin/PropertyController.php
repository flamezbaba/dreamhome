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
use App\Models\PropertyType;
use App\Models\PropertyCategory;
use App\Models\Currency;
use App\Exceptions\MyException;

class PropertyController extends Controller
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

        if ($request->delete_property == true) {
            $validator = Validator::make($request->all(), [
                'record_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $investment = Property::find($request->record_id);
                if ($investment) {

                    // foreach ($investment->pictures as $val) {
                    //     Storage::delete($val);
                    // }

                    $investment->delete();

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

        $records = Property::orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate(20)
            ->withQueryString()
            ->through(
                fn ($record) => [
                    "id" => $record->id,
                    "uuid" => $record->uuid,
                    "title" => $record->title,
                    "status" => $record->status,
                ]
            );

        return Inertia::render('Admin/Property/Index', [
            'page_title' => 'Property List',
            'filters' => $request->all('search'),
            'records' => $records,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->create_property == true) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'category' => 'required',
                'type' => 'required',
                'price' => 'required',
                'currency_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with('poperror', $validator->messages()->first());
            } else {
                $property = new Property();

                $property->uuid = mt_rand(1_111_111, 9_999_999);
                $property->title = $request->title;
                $property->price_suffix = $request->price_suffix;
                $property->price = FilterService::filAmount($request->price);
                $property->currency_id = $request->currency_id;
                $property->category = $request->category;
                $property->type = $request->type;
                $property->features = $request->specs;
                $property->bedrooms = $request->bedrooms;
                $property->toilets = $request->toilets;
                $property->bathrooms = $request->bathrooms;
                $property->parking_space = $request->parking_space;
                $property->status = "active";
                $property->state = $request->state;
                $property->city = $request->city;
                if(FilterService::filAmount($request->bonus)){
                    $property->bonus = FilterService::filAmount($request->bonus);
                }
                else{
                    $property->bonus = 0;
                }
                $property->description = $request->description;


                $pictures = [];
                if ($request->pictures) {
                    foreach ($request->pictures as $val) {
                        $pic = $val['image']->store("properties/img");
                        array_push($pictures, $pic);
                    }
                }
                $property->pictures = $pictures;

                

                $vids = [];
                if ($request->videos) {
                    foreach ($request->videos as $val) {
                        $v = $val['image']->store("properties/vids");
                        array_push($vids, $v);
                    }
                }
                $property->videos = $vids;

                $property->save();

                return redirect()
                    ->route('admin.property')
                    ->with('popsuccess', 'Operation Successful');
            }
        }

        return Inertia::render('Admin/Property/Create', [
            'page_title' => 'Create Property',
            'types' => PropertyType::all(),
            'categories' => PropertyCategory::all(),
            'currency' => Currency::all(),
        ]);
    }

    public function view($uuid, Request $request)
    {
        $property = Property::where("uuid", $uuid)->first();
        // dd($property->currency->first()->id);
        if ($property) {

            if ($request->edit_property == true) {
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'category' => 'required',
                    'type' => 'required',
                    'price' => 'required',
                    'currency_id' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('poperror', $validator->messages()->first());
                } else {
                    $property->title = $request->title;
                    $property->price_suffix = $request->price_suffix;
                    $property->price = FilterService::filAmount($request->price);
                    $property->currency_id = $request->currency_id;
                    $property->category = $request->category;
                    $property->type = $request->type;
                    $property->features = $request->specs;
                    $property->bedrooms = $request->bedrooms;
                    $property->toilets = $request->toilets;
                    $property->bathrooms = $request->bathrooms;
                    $property->parking_space = $request->parking_space;
                    $property->state = $request->state;
                    $property->city = $request->city;
                    if(FilterService::filAmount($request->bonus)){

                        $property->bonus = FilterService::filAmount($request->bonus);
                    }
                    else{
                        $property->bonus = 0;
                    }
                    $property->description = $request->description;

                    $property->save();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                }
            }

            if ($request->delete_image == true) {
                $validator = Validator::make($request->all(), [
                    'image' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('poperror', $validator->messages()->first());
                } else {
                    // dd($request->image);
                    $pictures = $property->pictures;
                    $new_pictures = [];
                    foreach ($pictures as $val) {
                        if ($val != $request->image) {
                            array_push($new_pictures, $val);
                        } else {
                            Storage::delete($val);
                        }
                    }

                    $property->pictures = $new_pictures;
                    $property->save();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                }
            }

            if ($request->upload_image == true) {
                $validator = Validator::make($request->all(), [
                    'image' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('poperror', $validator->messages()->first());
                } else {

                    $pictures = $property->pictures;
                    $pic = $request->image->store("properties/img");
                    array_push($pictures, $pic);
                    $property->pictures = $pictures;
                    $property->save();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                }
            }

            if ($request->delete_video == true) {
                $validator = Validator::make($request->all(), [
                    'vid' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('poperror', $validator->messages()->first());
                } else {
                    $pictures = $property->videos;
                    $new_pictures = [];
                    foreach ($pictures as $val) {
                        if ($val != $request->vid) {
                            array_push($new_pictures, $val);
                        } else {
                            Storage::delete($val);
                        }
                    }

                    $property->videos = $new_pictures;
                    $property->save();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                }
            }

            if ($request->upload_video == true) {
                $validator = Validator::make($request->all(), [
                    'vid' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('poperror', $validator->messages()->first());
                } else {

                    $pictures = $property->videos;
                    $pic = $request->vid->store("properties/vids");
                    array_push($pictures, $pic);
                    $property->videos = $pictures;
                    $property->save();

                    return redirect()
                        ->back()
                        ->with('popsuccess', 'Operation Successful');
                }
            }

            return Inertia::render('Admin/Property/View', [
                'page_title' => "$property->title",
                'property' => $property,
                'types' => PropertyType::all(),
                'categories' => PropertyCategory::all(),
                'currency' => Currency::all(),
            ]);
        } else {
            return redirect()
                ->route('admin.property')
                ->with('poperror', 'investment not found');
        }
    }
}
