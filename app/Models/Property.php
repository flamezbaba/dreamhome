<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Services\FilterService;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'properties';
    public $guarded = [];
    protected $casts = [
        "features" => 'array',
        "pictures" => 'array',
        "videos" => 'array',
    ];
    protected $appends = [
        'images', 'vids', 'currency'
    ];

    public function currency()
    {
        return $this->hasOne(Currency::class, "id", "currency_id");
    }

    public function getCurrencyAttribute()
    {
        return $this->currency()->first();
    }

    function getImagesAttribute()
    {
        $pictures = [];
        foreach ($this->pictures as $p) {
            // $url = url("storage/app/" . $p);
            // $url = asset("uploads/".$p);
            $url = asset($p);

            array_push($pictures, $url);
        }

        return $pictures;
    }

    function getVidsAttribute()
    {
        $pictures = [];

        foreach ($this->videos as $p) {
            // $url = asset("uploads/".$p);
            $url = asset($p);

            array_push($pictures, $url);
        }

        return $pictures;
    }

    public function scopeFilter($query, $filters)
    {
        // $query->when($filters['search'] ?? null, function ($query, $search) {
        //     if ($search == 'active') {
        //         $query->where('is_active', 1);
        //     } else {
        //         $query->where(function ($query) use ($search) {
        //             // $query
        //             //     ->where('fullname', 'like', '%' . $search . '%')
        //             //     ->orWhere('email', 'like', '%' . $search . '%')
        //             //     ->orWhere('gender', 'like', '%' . $search . '%')
        //             //     ->orWhere('full_address', 'like', '%' . $search . '%');
        //         });
        //     }
        // });
    }
}
