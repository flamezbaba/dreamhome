<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'admin' => Auth::guard('admin')->user() ? [
                    "id" => Auth::guard('admin')->user()->id,
                ] : null,
                'user' => Auth::guard('user')->user() ? [
                    "id" => Auth::guard('user')->user()->id,
                ] : null,
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                    'message' => $request->session()->get('message'),
                    'popsuccess' => $request->session()->get('popsuccess'),
                    'poperror' => $request->session()->get('poperror'),
                    'popmessage' => $request->session()->get('popmessage'),
                    'homesuccess' => $request->session()->get('homesuccess'),
                    'homeerror' => $request->session()->get('homeerror'),
                ];
            },
            'user' => null
        ]);
    }
}
