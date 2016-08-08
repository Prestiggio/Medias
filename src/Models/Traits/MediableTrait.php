<?php
namespace Ry\Medias\Models\Traits;

trait MediableTrait
{
	public function medias() {
		return $this->morphMany("Ry\Medias\Models\Media", "mediable");
	}
}