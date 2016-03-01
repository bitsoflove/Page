<?php namespace Modules\Page\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\Authentication;
use Modules\Page\Traits\QueryLimiterTrait;
use Modules\Site\Facades\Site;

class Page extends Model
{
    use Translatable;
    use QueryLimiterTrait;

    private $auth;

    protected $table = 'page__pages';
    public $translatedAttributes = [
        'page_id',
        'title',
        'slug',
        'status',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];
    protected $fillable = [
        'is_home',
        'template',
        // Translatable fields
        'page_id',
        'title',
        'slug',
        'status',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'site_id',
        'is_public',
    ];


    public function __construct(array $attributes=array()) {
        $this->auth = \App::make('Modules\Core\Contracts\Authentication');

        return parent::__construct($attributes);
    }

    public static function create(array $data=[]) {

        if(is_module_enabled('Site')) {
            $siteId = Site::id();
            $data['site_id'] = $siteId;
        }

        return parent::create($data);
    }
}
