<?php 
namespace Ry\Medias\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;

class AdminController extends Controller
{
	public function __construct() {
		$this->middleware("auth");
	}
	
	public function putMedias(&$mediable, $ar, $maincolumn=null) {
		foreach ( $ar ["medias"] as $media ) {
			if (isset ( $media ["path"] ) && $media ["path"] != "") {
				$m = $mediable->medias ()->where("id", "=", $media["id"])->first();
				if(!$m) {
					$m = $mediable->medias ()->create ( [
							"path" => $media ["path"],
							"mediable_type" => Immobilier::class,
							"mediable_id" => $mediable->id
					] );
				}
		
				if(isset($media["deleted"])) {
					if(!preg_match("/^https?:\/\//i", $m->path)) {
						$fs = new Filesystem();
						$fs->delete(public_path("uploads/" . $m->path));
					}
					$m->delete();
				}
				if(isset($main) && isset($ar["main_media_path"]["path"]) && $ar["main_media_path"]["path"]==$media ["path"]) {
					$mediable->$main = $m->id;
					$mediable->save ();
				}
			}
		}		
	}
}

?>