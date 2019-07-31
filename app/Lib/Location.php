<?php
namespace App\Lib;
use Storage;

class Location
{
    public static $data = [];

    public static function load()
    {
        if (count(static::$data) > 0) {
            return;
        }
        $data = Storage::disk('storage')->get('location.json');
        static::$data = json_decode($data, true);
    }

    public static function getCitySlug($slug)
    {   
        foreach (static::$data as $city) {
            if (str_slug($city['name']) == $slug) {
                return $city;
            }
        }
        return null;
    }

    public static function getCity($id)
    {
        foreach (static::$data as $city) {
            if ($city['id'] == $id) {
                return $city;
            }
        }
        return null;
    }

    public static function getDistrict($id)
    {
        foreach (static::$data as $city) {
            foreach ($city['district'] as $dist) {
                if ($dist['id'] == $id) {
                    return $dist;
                }
            }
        }
        return null;
    }


    public static function getDistrictSlug($slug)
    {   
        foreach (static::$data as $city) {
            foreach ($city['district'] as $dist) {
                if (str_slug($dist['name']) == $slug) {
                    return $dist;
                }
            }
        }
        return null;
    }


    public static function getWard($id)
    {
        foreach (static::$data as $city) {
            foreach ($city['district'] as $dist) {
                foreach ($dist['ward'] as $ward) {
                    if ($ward['id'] == $id) {
                        return $ward;
                    }
                }
            }
        }
        return null;
    }

    public static function getStreet($id)
    {
        foreach (static::$data as $city) {
            foreach ($city['district'] as $dist) {
                foreach ($dist['street'] as $street) {
                    if ($street['id'] == $id) {
                        return $street;
                    }
                }
            }
        }
        return null;
    }
}