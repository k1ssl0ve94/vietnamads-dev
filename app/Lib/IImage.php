<?php

namespace App\Lib;

use Image;
use Storage;

class IImage
{
    public static function toThumbName($filename)
    {
        return substr($filename, 0, strrpos($filename, '.')) . '_thumb.jpg';
    }

    public static function filePath($filename, $folder)
    {
        return 'uploads/' . $folder . '/' . $filename;
    }

    public static function upload($file, $folder)
    {
        $filename = str_random(32) . '.' . $file->extension();
        $filePath = self::filePath($filename, $folder);

        $img = Image::make($file);
        $img->orientate();
        $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        Storage::disk('public')->put($filePath, $img->encode('jpg', 80), 'public');

        return [
            'filename' => $filename,
            'url' => Storage::disk('public')->url($filePath),
        ];
    }

    public static function uploadGIF($file, $folder)
    {
        $filename = str_random(32) . '.' . $file->extension();
        $file->storeAs('uploads/' . $folder, $filename, 'public');

        return [
            'filename' => $filename,
            'url' => Storage::disk('public')->url($filePath),
        ];
    }

    public static function makeThumb($filename, $folder)
    {
        $filePath = self::filePath($filename, $folder);
        $file = Image::make(Storage::disk('public')->get($filePath));

        $file->orientate();
        $file->fit(200, 144,function ($constraint) {
            $constraint->upsize();
        });
        // do crop by ratio here

        $thumbFilename = self::toThumbName($filename);
        $thumbFilePath = 'uploads/' . $folder . '/' . $thumbFilename;

        Storage::disk('public')->put($thumbFilePath, $file->encode('jpg', 100), 'public');

        return [
            'filename' => $thumbFilename,
            'url' => Storage::disk('public')->url($thumbFilePath),
        ];
    }

    public static function addWaterMark($filename, $folder, $size = 'sm')
    {
        $filePath = self::filePath($filename, $folder);
        $img = Image::make(Storage::disk('public')->get($filePath));

        if ($size == 'lg') {
            $img->insert(public_path('imgs/watermark_new.png'), 'center');
        } else {
            $img->insert(public_path('imgs/watermark_new_sm.png'), 'center');
        }

        Storage::disk('public')->put($filePath, $img->encode('jpg', 100), 'public');

        return [
            'filename' => $filename,
            'url' => Storage::disk('public')->url($filePath),
        ];
    }
}