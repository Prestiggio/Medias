<?php
namespace Ry\Medias\Models\Traits;

trait MediaOwnerTrait
{
	public function medias() {
		return $this->hasMany("Ry\Medias\Models\Media", "owner_id");
	}
}