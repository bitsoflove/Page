<?php namespace Modules\Page\Traits;

trait MultiSiteTenancyTrait {

    public function newQuery()
    {
        $query = parent::newQuery();
        $siteId = session('site-id');

        if(!empty($siteId)) {
            $query->where('site_id', '=', $siteId);
        }
        return $query;
    }
}
