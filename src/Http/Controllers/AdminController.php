<?php 
namespace Ry\Medias\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Ry\Medias\Models\Media;

class AdminController extends Controller
{
	public function __construct() {
		$this->middleware("auth");
	}
	
	public function putMedias(&$mediable, $ar, $maincolumn=null) {
		Media::unguard();
		foreach ( $ar ["medias"] as $media ) {
			if (isset ( $media ["path"] ) && $media ["path"] != "") {
				if(isset($media["id"])) { //cas uploaded ou update
					$m = $mediable->medias ()->where("id", "=", $media["id"])->first();
					if(!$m) {
						$m = $mediable->medias ()->create ( [
								"path" => $media ["path"],
								"mediable_type" => get_class($mediable),
								"mediable_id" => $mediable->id
						] );
					}
				}
				else { //cas facebook pick
					$m = $mediable->medias ()->create ( [
							"path" => $media ["path"],
							"mediable_type" => get_class($mediable),
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
		Media::reguard();
	}
}

?>