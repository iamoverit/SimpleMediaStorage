<?php


namespace App\Http\Controllers;


trait Storable
{
    private static function uploadedPath(){
        return '/uploaded';
    }
}