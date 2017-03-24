<?php

namespace Ry\Medias\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "ry_medias_medias";

    protected $visible = ["title", "descriptif", "path", "type", "id", "contrast", "height", "url"];

    protected $appends = ["contrast", "url"];
    
    public function mediable() {
    	return $this->morphTo();
    }

    public function owner() {
        return $this->belongsTo("App\User", "owner_id");
    }

    public function getContrastAttribute() {
        //return RGB colors

        $color = [0, 0, 0];

        if(preg_match("/brown/i", $this->descriptif))
            $color = [172, 142, 138];

        if(preg_match("/red/i", $this->descriptif))
            $color = [250, 247, 238];

        if(preg_match("/yellow/i", $this->descriptif))
            $color = [250, 247, 238];

        if(preg_match("/green/i", $this->descriptif))
            $color = [160, 194, 196];

        return $color;
    }
    
    public function getUrlAttribute() {
    	if(preg_match("/^https?:\/\//i", $this->path))
    		return $this->path;
    	return url("uploads/" . $this->path);
    }
}
