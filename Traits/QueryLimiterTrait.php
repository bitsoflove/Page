<?php namespace Modules\Page\Traits;

use Modules\Site\Facades\SiteGateway;
use \Site;

trait QueryLimiterTrait {



    public function newQuery()
    {
        $query = parent::newQuery();
        if (is_module_enabled('Site')) {
            $this->appendSiteWhereClause($query);
        }

        if(empty($this->auth->check())) {
            $this->appendPublicWhereClause($query);
        }

        return $query;
    }

    private function appendSiteWhereClause($query) {
      $siteId = Site::id();
      if(!empty($siteId)) {
          $query->where('site_id', '=', $siteId);
      }
    }

    private function appendPublicWhereClause($query) {
        $query->where('is_public', 1);
    }
}
