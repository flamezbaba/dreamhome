<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $guarded = [];

    protected $appends = [
        'receipt_url', "the_property"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id",);
    }

    public function getThePropertyAttribute()
    {

        return $this->property;
    }

    public function getReceiptUrlAttribute()
    {
        if ($this->receipt) {
            // return asset("uploads/".$this->receipt);
            return asset($this->receipt);
            // return url("storage/app/$this->receipt");
        }

        return null;
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
