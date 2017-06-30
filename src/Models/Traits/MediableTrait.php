<?php
namespace Ry\Medias\Models\Traits;

trait MediableTrait
{
	public function medias() {
		return $this->morphMany("Ry\Medias\Models\Media", "mediable");
	}
	
	public function getThumbAttribute() {
		if($this->thumbnail)
			return $this->thumbnail;
		
		foreach($this->medias as $media) {
			return $media->url;
		}
		 
		return $this->default_thumb;
	}
	
	public function thumbnail() {
		return $this->belongsTo("Ry\Medias\Models\Media", $this->thumbnail_field);
	}
}