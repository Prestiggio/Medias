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
use Facebook\Facebook;
use Facebook\GraphNodes\GraphObject;
use Illuminate\Support\Facades\Log;

use Illuminate\Filesystem\Filesystem;

class PublicJsonController extends Controller
{
	public function getIndex() {
		return Auth::user();
	}
	
	public function publish($media) {
		if(!preg_match("/^https?:\/\//i", $media->path)) {
			$fb = new Facebook([
					'app_id' => "691462271025098",
					"app_secret" => "635f60e1510231ea5bb5cae9a3f60b47",
					"default_graph_version" => "v2.8"
			]);
			$fb->setDefaultAccessToken("EAAJ04ZAsKP8oBALZBrEz3esv45Ch4pZC8BbfwSrW21oszL7qB5B5DpQezZBt4sulOHx1ofpHH3RNzMtf3Ti8GS6pOmZCvLsmIeYrKJ1aIewNGQUIBxUEWwyvQvoapoenfjTpJb7zKhMUpXo5QV2LUIMMZBOROqO9CNmzgC2rcMbwZDZD");
			$fbrequest = $fb->request('POST', '/1464752153547049/photos', [
					"message" => $media->title,
					"source" => $fb->fileToUpload(public_path($media->path))
			]);
			$response = $fb->getClient()->sendRequest($fbrequest)->getGraphNode();
			$path = "https://graph.facebook.com/" . $response->getField("id", 666834146842093) . "/picture";
			
			$fs = new Filesystem();
			$fs->delete(public_path($media->path));
			
			$media->path = $path;
			$media->save();
		}
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
	
		/*try {
			$fb = new Facebook([
					'app_id' => "691462271025098",
					"app_secret" => "635f60e1510231ea5bb5cae9a3f60b47",
					"default_graph_version" => "v2.8"
			]);
			$fb->setDefaultAccessToken("EAAJ04ZAsKP8oBALZBrEz3esv45Ch4pZC8BbfwSrW21oszL7qB5B5DpQezZBt4sulOHx1ofpHH3RNzMtf3Ti8GS6pOmZCvLsmIeYrKJ1aIewNGQUIBxUEWwyvQvoapoenfjTpJb7zKhMUpXo5QV2LUIMMZBOROqO9CNmzgC2rcMbwZDZD");
			$fbrequest = $fb->request('POST', '/1464752153547049/photos', [
					"message" => "Nouveauté sur Kipa",
					"source" => $fb->fileToUpload($file->getPathname())
			]);
			$response = $fb->getClient()->sendRequest($fbrequest)->getGraphNode();
			$path = "https://graph.facebook.com/" . $response->getField("id", 666834146842093) . "/picture";
		}
		catch(\Exception $e) {*/
			$path = time() . "-" . $file->getClientOriginalName();
			$file->move(public_path(), $path);
		//}
		
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