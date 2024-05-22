<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    use HasFactory;

    protected $table = 'property_categories';
    public $guarded = [];

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
