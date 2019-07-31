<?php
namespace App\Repositories;
use App\Tag;

class TagRepository
{
    public function add($name)
    {
        $t = new Tag;
        $t->name = strtolower(trim($name));
        if ($t->save()) {
            return $t;
        }
        return null;
    }

    public function searchByName($name)
    {
        return Tag::where('name', 'like', '%'.$name.'%')->limit(100)->get();
    }

    public function findByName($name)
    {
        $name = strtolower(trim($name));
        return Tag::where('name', $name)->first();
    }

    public function getByID($id)
    {
        return Tag::find($id);
    }
}