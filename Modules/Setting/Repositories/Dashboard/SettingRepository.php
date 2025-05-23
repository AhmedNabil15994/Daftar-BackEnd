<?php

namespace Modules\Setting\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Modules\Core\Traits\CoreTrait;
use Setting;

class SettingRepository
{
    use CoreTrait;

    protected $editor;

    /*function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }*/

    public function set($request)
    {
        $this->saveSettings($request->except('_token', '_method'));
        return true;
    }

    public function saveSettings($request)
    {
        foreach ($request as $key => $value) {

            if ($key == 'translate')
                static::setTranslatableSettings($value);

            if ($key == 'images')
                static::setImagesPath($value);

            if ($key == 'env')
                static::setEnv($value);

            Setting::set($key, $value);
        }
    }

    public static function setTranslatableSettings($settings = [])
    {
        foreach ($settings as $key => $value) {
            Setting::lang(locale())->set($key, $value);
        }
    }

    public static function setImagesPath($settings = [])
    {
        foreach ($settings as $key => $value) {

            if ($value) {
                if (!empty(config('setting.' . $key)) && !in_array(config('setting.' . $key), config('core.config.special_images'))) {
                    File::delete(config('setting.' . $key)); ### Delete old image
                }
                $imgName = (new static)->uploadImage(public_path(config('core.config.settings_img_path')), $value);
                $img = config('core.config.settings_img_path') . '/' . $imgName;
            } else {
                $img = config('setting.' . $key);
            }

            Setting::set($key, $img);
//            Setting::set($key, path_without_domain($value));
        }
    }

    public static function setEnv($settings = [])
    {
        foreach ($settings as $key => $value) {
            $file = DotenvEditor::setKey($key, $value, '', false);
        }

        $file = DotenvEditor::save();
    }
}
