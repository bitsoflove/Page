<?php namespace Modules\Page\Traits;

trait MultiSiteTenancyTrait {

    public function newQuery()
    {
        $query = parent::newQuery();
        if (is_module_enabled('Site')) {
            $this->appendWhereClause($query);
        }

        return $query;
    }

    private function appendWhereClause($query) {
      $siteId = session('site-id');
      if(!empty($siteId)) {
          $query->where('site_id', '=', $siteId);
      }
    }
}
