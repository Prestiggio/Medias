<?php
namespace Ry\Medias\Http\Controllers;

use App\Http\Controllers\Controller;
use Ry\Medias\Model\Media;
use Illuminate\Http\Request;
use Auth;
use Ry\Medias\Model\Resizing;
use Illuminate\Support\Facades\File;
use PHPImageWorkshop\ImageWorkshop;
use Gregwar\Image\Image;

class PublicJsonController extends Controller
{
	public function getIndex() {
		
	}
	
	public function postSave(Request $request) {
		$files = $request->files->all();
	
		/*
		 curl -H "appId:bf329376-d015-11e5-9d94-3c07545ccc07" -H "secret:e87f20d2-d015-11e5-ae17-3c07545ccc07" http://yeswedo.mg/en/storage/save
		 -F "file[rajan]=@/Users/landry/Documents/www/IMI/yeswedo/laravel/readme.md"
		 -F "file[gugus]=@/Users/landry/Documents/www/IMI/yeswedo/laravel/readme.md"
		 -F "title[rajan]=mistorio"
		 -F "title[gugus]=mevator"
		 -F "description[rajan]=piol"
		 -F "description[gugus]=dffgg"
		*/
	
		$ar = [];
	
		$or = $request->all();
	
		foreach ($files["file"] as $k => $file) {
			$path = time() . "-" . $file->getClientOriginalName();
			$file->move(public_path("uploads"), $path);
	
			Media::unguard();
	
			$media = Auth::user()->medias()->create([
					"title" => $or['title'][$k],
					"description" => $or['description'][$k],
					"path" => $path,
					"height" => isset($or['height'][$k]) ? $or['height'][$k] : 480/600,
					"type" => $or['type'][$k]
			]);
	
			$ar[$k] = $media->id;
	
			Media::reguard();
		}
	
		return $ar;
	}
}