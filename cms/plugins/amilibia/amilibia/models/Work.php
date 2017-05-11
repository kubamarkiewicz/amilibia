<?php namespace Amilibia\Amilibia\Models;

use Model;

/**
 * Model
 */
class Work extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'amilibia_amilibia_works';


    /*
     * Relations
     */
    public $attachMany = [
        'images' => 'System\Models\File'
    ];
}