<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware {
    /**
     * The trusted proxies for this application.
     *
     * @var string|array
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var string
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}