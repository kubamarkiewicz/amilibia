<?php namespace Amilibia\Amilibia\Models;

use Model;

/**
 * Model
 */
class Product extends Model
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
    public $table = 'amilibia_amilibia_products';

    /*
     * Relations
     */
    public $attachOne = [
        'icon' => 'System\Models\File',
        'image' => 'System\Models\File'
    ];


    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name', 'description'];
    
}