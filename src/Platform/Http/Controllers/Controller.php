<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

/**
 * Class Controller.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkPermission(string $permission): void
    {
        $this->middleware(static function ($request, $next) use ($permission) {
            if (auth()->user()?->hasAccess($permission)) {
                return $next($request);
            }
            abort(403);
        });

        abort_if(auth()->user() !== null && ! auth()->user()?->hasAccess($permission), 403);
    }
}
