<?php

use App\Http\Controllers\Web\Admin\{PropertyController, UserController, OrderController, SettingsController};

Route::any('/properties', [PropertyController::class, 'index'])->name(
    'property'
);

Route::any('/properties/create', [PropertyController::class, 'create'])->name(
    'property.create'
);

Route::any('/properties/view/{uuid}', [PropertyController::class, 'view'])->name(
    'property.view'
);

Route::any('/users', [UserController::class, 'index'])->name(
    'user'
);


Route::any('/orders', [OrderController::class, 'index'])->name(
    'order'
);


Route::any('/settings/bank', [SettingsController::class, 'bank'])->name(
    'settings.bank'
);
