<?php
namespace Ry\Medias\Http\Controllers;

use App\Http\Controllers\Controller;
use Ry\Medias\Models\Media;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Ry\Medias\Models\Resizing;
use Illuminate\Support\Facades\File;
use PHPImageWorkshop\ImageWorkshop;
use Gregwar\Image\Image;

class PublicJsonController extends Controller
{
	public function getIndex() {
		return Auth::user();
	}
	
	public function getTest() {
		return Auth::user();
	}
	
	public function postSave(Request $request) {
		$file = $request->file("file");
		
		/*
		 curl -H "appId:bf329376-d015-11e5-9d94-3c07545ccc07" -H "secret:e87f20d2-d015-11e5-ae17-3c07545ccc07" http://yeswedo.mg/en/storage/save
		 -F "file[rajan]=@/Users/landry/Documents/www/IMI/yeswedo/laravel/readme.md"
		 -F "file[gugus]=@/Users/landry/Documents/www/IMI/yeswedo/laravel/readme.md"
		 -F "title[rajan]=mistorio"
		 -F "title[gugus]=mevator"
		 -F "description[rajan]=piol"
		 -F "description[gugus]=dffgg"
		*/
	
		$path = time() . "-" . $file->getClientOriginalName();
		$file->move(public_path("uploads"), $path);
		
		Media::unguard();
		
		$user = Auth::user();
		
		if(!$user) {
			$user = User::where("id", "=", 1)->first();
		}
		
		$media = Media::create([
				"owner_id" => $user->id,
				"title" => $request->get("title"),
				"descriptif" => $request->get("descriptif"),
				"path" => $path,
				"height" => $request->get("height", 480/600),
				"type" => $request->get("type", "application/unknown")
		]);
		
		Media::reguard();
	
		return $media;
	}
}