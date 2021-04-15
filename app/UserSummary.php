<?php

/**
 * User Summary Model
 *
 * @category   User Summary
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserSummary
 * @package App
 */
class UserSummary extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_summary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['org_id', 'user_id', 'stats', 'specimen_stats', 'dna_stats','isotope_stats', 'dental_stats',
        'project_stats', 'user_stats', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function org()
    {
        return $this->belongsTo('App\Org', 'org_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
