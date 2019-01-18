<?php

namespace Ry\Medias\Models;

use Illuminate\Database\Eloquent\Model;
use Facebook\Facebook;

class Media extends Model
{
    protected $table = "ry_medias_medias";

    protected $visible = ["title", "descriptif", "type", "id", "contrast", "height", "url", "fullpath", "path"];

    protected $appends = ["contrast", "url", "fullpath"];
    
    protected $fillable = ["path", "owner_id"];
    
    private static $fbAccessToken;
    
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
    	return url($this->path);
    }
    
    private function fbAccessToken() {
    	if(!self::$fbAccessToken) {
    		$fb = new Facebook([
    				'app_id' => "691462271025098",
    				"app_secret" => "635f60e1510231ea5bb5cae9a3f60b47",
    				"default_graph_version" => "v2.8"
    		]);
    		self::$fbAccessToken = "691462271025098|XUAEe8dph6vurtkHnif5uOP5BeA";
    	}
    	
    	return self::$fbAccessToken;
    }
    
    public function getFullpathAttribute() {
    	if(preg_match("/^https?:\/\//i", $this->path)) {
    		if(preg_match("/^https:\/\/graph\.facebook\.com\/\d+\/picture\/?$/i", $this->path)) {
    			$this->path .= '?access_token=' . $this->fbAccessToken();
    		}
    		return $this->path;
    	}
    	return url($this->path);
    }
}
