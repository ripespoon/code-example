<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnDemandCategory extends Model
{
    use HasFactory;

    protected $table = 'on_demand_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'created_by'
    ];

    /**
     * The attributes that are appended to each response.
     *
     * @var array
     */
    protected $appends = [
        'created_human',
        'excerpt'
    ];

    /**
     * Get the human formatted created at attribute.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return Carbon
     */
    public function getCreatedHumanAttribute()
    {
        return $this->created_at->format('g:ia l dS F');
    }

    /**
     * Get a smaller version of the main description field.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return String
     */
    public function getExcerptAttribute()
    {
        return substr($this->description, 0, 150) . '...';
    }

    /**
     * This relationship returns all of the on demand videos assigned to this category.
     */
    public function videos()
    {
        return $this->belongsToMany('App\Models\OnDemand', '_pivot_on_demand_categories', 'id', 'on_demand_id');
    }
}
