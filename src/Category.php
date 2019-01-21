<?php

namespace Laradin\Category;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const ACTIVE_YES = 1;
    const ACTIVE_NO  = 0;

    public static $separator = ' / ';

    protected $fillable = ['parent_id', 'name', 'description', 'active'];
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('category.table'));
    }    

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {            
            $model->active = $model->active === 'on' ? self::ACTIVE_YES : self::ACTIVE_NO;
            if (!$model->parent_id) {
                $model->parent_id = null;
            }
        });

        self::saved(function ($model) {

        });

        self::retrieved(function ($model) {
            
        });
    }

    /**
     * get flatten nested array list
     * 
     * @param  int|null  $parentId
     * @param  array  $excludes
     * @param  string|false  $root
     * 
     * @return array
     */
    public static function getList($parentId = null, array $excludes = [], $root = 'Root')
    {
        $lists = [];
        if (is_null($parentId) && count($lists) == 0 && false!==$root) {
            $lists[] = $root;
        }
        $query = static::where('parent_id', $parentId);

        if (count($excludes)>0) {
            $query->whereNotIn('id', $excludes);
        }

        $query->get()->each(function ($c) use (&$lists, $excludes, $root) { 
            $lists[$c->id] = $c->full_name;
            if ($c->childs->count() > 0) {
                $lists += static::getList($c->id, $excludes, $root);
            }
        });
        
    	return $lists;
    }

    public function getFullNameAttribute()
    {
    	return $this->parent ? $this->parent->full_name . self::$separator .  $this->name : $this->name;
    }

    public function getActiveLabelAttribute()
    {
        return self::ACTIVE_YES == $this->active ? laradin_trans('Active') : laradin_trans('Not Active');
    }

    public function parent()
    {
    	return $this->belongsTo(self::class, 'parent_id');
    }

    public function childs()
    {
    	return $this->hasMany(self::class, 'parent_id');
    }

}
