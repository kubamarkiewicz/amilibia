<?php namespace KubaMarkiewicz\Translations\Models;

use Model;

/**
 * Model
 */
class Translation extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    
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
    public $table = 'kubamarkiewicz_translations_translations';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel']; 

    public $translatable = ['translation'];

    const TYPE_TEXT = '';  
    const TYPE_RICHEDITOR = 'richeditor';  
    const TYPE_IMAGE_UPLOAD = 'image-upload';  
    const TYPE_FILE_UPLOAD = 'file-upload'; 
    const TYPE_IMAGE_MEDIAFINDER = 'image-mediafinder'; 
    const TYPE_FILE_MEDIAFINDER = 'file-mediafinder'; 
    const TYPE_REPEATER = 'repeater';  

    /*
     * Relations
     */
    public $attachOne = [
        'image' => 'System\Models\File'
    ];  

    public $attachMany = [
        'images' => 'System\Models\File'
    ];

    protected $jsonable = ['json_data', 'parameters'];


    public function getKeyAttribute()
    {
        if ($this->parent_id) {
            $parent = $this->getParent()->first();
            return $parent ? $parent->key.'.'.$this->code : false;
        }
        else {
            return $this->code;
        }
    }


    public function getTypeOptions()
    {
        return [
            self::TYPE_TEXT => '&nbsp;',
            self::TYPE_RICHEDITOR => self::TYPE_RICHEDITOR,
            self::TYPE_IMAGE_UPLOAD => self::TYPE_IMAGE_UPLOAD, 
            self::TYPE_FILE_UPLOAD => self::TYPE_FILE_UPLOAD, 
            self::TYPE_IMAGE_MEDIAFINDER => self::TYPE_IMAGE_MEDIAFINDER,
            self::TYPE_FILE_MEDIAFINDER => self::TYPE_FILE_MEDIAFINDER,
            self::TYPE_REPEATER => self::TYPE_REPEATER,
        ];
    }

    public function beforeUpdate()
    {
        // echo 'kuba_'.$this->id; exit;
/*        
        $sessionKey = \Input::get('_session_key');

        // returns the latest file uploaded in the current session
        // is this a reliable approach?
        $file = $this
            ->import_file()
            ->withDeferred($sessionKey)
            ->latest()
            ->first();

        
        $file->attachment_id = $this->id;
        $file->attachment_type = 'KubaMarkiewicz\Translations\Models\Translation';
        $file->field = 'file_'.$this->id;
        $file->save();
        // dump($file->getLocalPath());    
        // return false;
*/
    }

    public static function translate($key)
    {
        // todo: change language
/*        if ($lang) {
            Translator::instance()->setLocale($lang);
        }*/

        $slugs = explode('.', $key);
        $parentId = 0;
        // dump($parent); exit;
        if ($slugs) foreach ($slugs as $slug) {
            $item = self::where('parent_id', $parentId)->where('code', $slug)->first();
            if ($item) {
                $parentId = $item->id;
            }
            else {
                break;
            }
        }
        if (!$item) {
            return;
        }

        switch ($item->type) {
            case self::TYPE_IMAGE_MEDIAFINDER:
                $file = \Config::get('cms.storage.media.path').$item->translation;
                if (file_exists(base_path().$file) && $item->parameters && $item->parameters['width'] && $item->parameters['height']) {
                    $image = new Image($file);
                    $image->resize($item->parameters['width'], $item->parameters['height'], ['mode' => isset($item->parameters['mode']) ? $item->parameters['mode'] : 'auto']);
                    return (string) $image;
                }
                else {
                    return url($file);
                }
            default:
                return $item->translation;
        }

        
    }
}