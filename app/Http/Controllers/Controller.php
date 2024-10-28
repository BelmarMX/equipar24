<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

abstract class Controller
{
    public static function set_actions($resource_name, $field_name = 'title', $divider = FALSE, $restore = FALSE, $edit = TRUE, $delete = TRUE, $related_opt = NULL, $images_opt = NULL, $videos_opt = NULL, $download_opt = NULL)
    {
        return [
                'field_name'    => $field_name
            ,   'custom'        => [
                    'related'   => $related_opt
                ,   'images'    => $images_opt
                ,   'video'     => $videos_opt
                ,   'download'  => $download_opt
            ]
            ,   'divider'       => $divider
            ,   'edit'          => [
                    'enabled'   => !$restore && $edit
                ,   'route'     => $resource_name.'.edit'
            ]
            ,   'delete'        => [
                    'enabled'   => !$restore && $delete
                ,   'route'     => $resource_name.'.delete'
            ]
            ,   'restore'       => [
                    'enabled'   => $restore
                ,   'route'     => $resource_name.'.restore'
            ]
        ];
    }

    public static function store_all_images_from_request($original_field, $mobile_field, $title, $folder, $resize = FALSE, $resize_width = 0, $resize_height = 0, $remove_original = FALSE, $remove_mobile = FALSE, $remove_original_cut = FALSE)
    {
        $return                 = new \stdClass();
        if( !empty($original_field) )
        {
            $stored_image           = self::store_image(
                    $original_field
                ,   $title
                ,   $folder
                ,   TRUE
                ,   $resize, $resize_width, $resize_height
                ,   FALSE, 0, 0, 0, 0
            );
        }
        if( !empty($mobile_field) )
        {
            $stored_mobile_image           = self::store_image(
                    $mobile_field
                ,   $title.' mobile'
                ,   $folder
            );
        }

        $return -> full     = $stored_image         ?? NULL;
        $return -> mobile   = $stored_mobile_image  ?? NULL;

        if( $return -> full && $remove_original)
        {
            Storage::disk('public')->delete($folder.'/'.$remove_original);
            if( $resize )
            {
                Storage::disk('public')->delete($folder.'/'.$remove_original_cut);
            }
        }
        if( $return -> mobile && $remove_mobile)
        {
            Storage::disk('public')->delete($folder.'/'.$remove_mobile);
        }
        return $return;
    }

    public static function set_image_names($title, $web_p = FALSE, $file_original_name = NULL)
    {
        $extension                  = 'webp';
        if( !$web_p )
        {
            $extension              = pathinfo($file_original_name, PATHINFO_EXTENSION);
        }

        $time                       = time();
        $title                      = Str::slug($title);
        $names                      = new \stdClass();
        $names -> format            = $extension;
        $names -> original          = $title."-{$time}.{$extension}";
        $names -> thumb             = $title."-thumbnail-{$time}.{$extension}";
        $names -> crop              = $title."-cropped-{$time}.{$extension}";

        return $names;
    }

    public static function store_image($request_file, $image_name, $storage_folder, $convert_webp = TRUE, $thumbnail = FALSE, $thumbnail_width = 0, $thumbnail_height = 0, $crop = FALSE, $crop_width = 0, $crop_height = 0, $crop_x = 0, $crop_y = 0)
    {
        $return                             = new \stdClass();
        $file_names                         = self::set_image_names($image_name, $convert_webp, $request_file -> getClientOriginalName());
        $image_manager                      = ImageManager::imagick() -> read($request_file);

        $return -> original                 = self::save_original_image($image_manager, $file_names -> format, $file_names -> original, $storage_folder);
        if( $thumbnail )
        {
            $return -> thumbnail            = self::save_resized_image($image_manager, $file_names -> format, $file_names -> thumb, $storage_folder, $thumbnail_width, $thumbnail_height);
        }
        if( $crop )
        {
            $return -> cropped              = self::save_cropped_image($image_manager, $file_names -> format, $file_names -> crop, $storage_folder, $crop_width, $crop_height, $crop_x, $crop_y);
        }

        return $return;
    }

    public static function save_original_image($file, $type, $file_name, $storage_folder)
    {
        switch($type)
        {
            case 'webp':
                $encoded = $file -> toWebp(85);
            break;
            case 'jpeg':
            case 'jpg':
                $encoded = $file -> toJpeg(90);
            break;
            case 'png':
                $encoded = $file -> toPng();
            break;
            default: return NULL;
        }
        if( Storage::disk('public')->put($storage_folder.'/'.$file_name, $encoded) )
        {
            return $file_name;
        }
        return NULL;
    }

    public static function save_resized_image($file, $type, $file_name, $storage_folder, $width, $height)
    {
        $file -> cover($width, $height, 'center');
        switch($type)
        {
            case 'webp':
                $encoded = $file -> toWebp(85);
            break;
            case 'jpeg':
            case 'jpg':
                $encoded = $file -> toJpeg(90);
            break;
            case 'png':
                $encoded = $file -> toPng();
            break;
            default: return NULL;
        }
        if( Storage::disk('public')->put($storage_folder.'/'.$file_name, $encoded) )
        {
            return $file_name;
        }
        return NULL;
    }

    public static function save_cropped_image($file, $type, $file_name, $storage_folder, $width, $height, $from_x, $from_y)
    {
        $file -> crop($width, $height, $from_x, $from_y);
        switch($type)
        {
            case 'webp':
                $encoded = $file -> toWebp(85);
                break;
            case 'jpeg':
            case 'jpg':
                $encoded = $file -> toJpeg(90);
                break;
            case 'png':
                $encoded = $file -> toPng();
                break;
            default: return NULL;
        }
        if( Storage::disk('public')->put($storage_folder.'/'.$file_name, $encoded) )
        {
            return $file_name;
        }
        return NULL;
    }

    public static function delete_image(array $images, $storage_folder)
    {
        foreach($images as $image)
        {
            Storage::disk('public')->delete($storage_folder.$image);
        }
    }

    public static function store_file($request_file, $file_name, $storage_folder, $remove_current = NULL)
    {
        if( empty($request_file) )
        { return NULL; }

        $time           = time();
        $original       = $request_file -> getClientOriginalName();
        $extension      = pathinfo($original, PATHINFO_EXTENSION);
        $file_name      = Str::slug($file_name)."-{$time}.{$extension}";
        $storage_folder = rtrim($storage_folder, '/');

        if( $request_file->storeAs($storage_folder, $file_name, ['disk' => 'public']) )
        {
            if( !empty($remove_current) )
            {
                Storage::disk('public')->delete($storage_folder.'/'.$remove_current);
            }
            return $file_name;
        }
        return NULL;
    }
}
