<?php

namespace App\Classes;


use Illuminate\Support\Str;

class EditorJS
{
    public static function correct_images_src($raw_editor)
    {
        if( !Str::contains($raw_editor, 'image') )
        {
            return $raw_editor;
        }

        $blocks         = json_decode($raw_editor);
        $parsed_blocks  = [];

        foreach ($blocks->blocks as $block)
        {
            if( $block->type == 'image' )
            {
                $block->data->url = $block->data->file->url;
            }
            $parsed_blocks[] = $block;
        }
        return json_encode([
                'time'      => $blocks->time
            ,   'blocks'    => $parsed_blocks
            ,   'version'   => $blocks->version
        ]);
    }
}
