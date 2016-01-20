<?php namespace Modules\Page\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class RedirectRootToSiteHomepage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->isOnRootDomain()) {
            return $this->redirectToSiteHomepage();
        }

        return $next($request);
    }

    private function isOnRootDomain() {
        $firstSegment = \Illuminate\Support\Facades\Request::segment(1);
        return empty($firstSegment);
    }

    private function redirectToSiteHomepage() {
        $site = \Site::current();
        $homepage = $site->pages->where('is_home', 1)->first();
        $pageSlug = $homepage->slug;

        $url = URL::to('/') . '/' . $pageSlug;
        return Redirect::to($url, 301);
    }
}
