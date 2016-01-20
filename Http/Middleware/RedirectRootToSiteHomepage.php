<?php namespace Modules\Page\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
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
        //only try redirecting when we're on the root of the domain
        if($this->isOnRootOfDomain()) {

            //only try redirecting if we found a homepage, and the homepage URL is not the same as our root domain
            if(!empty($homepage = $this->getHomepage()) && !empty($homepage->slug)) {

                //alright, let's redirect then
                return $this->redirectToPage($homepage);
            }
        }

        return $next($request);
    }

    private function isOnRootOfDomain() {
        $firstSegment = \Illuminate\Support\Facades\Request::segment(1);
        return empty($firstSegment);
    }

    private function getHomepage() {
        $homepage = null;
        try {
            $site = \Site::current();
            $homepage = $site->pages->where('is_home', 1)->first();
        } catch(\Exception $e) {
            Log::critical($e);
        }

        return $homepage;
    }

    private function redirectToPage($page) {
        $pageSlug = $page->slug;
        $url = URL::to('/') . '/' . $pageSlug;
        return Redirect::to($url, 301);
    }
}
