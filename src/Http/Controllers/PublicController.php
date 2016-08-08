<?php
namespace Ry\Medias\Http\Controllers;

use App\Http\Controllers\Controller;
use Ry\Medias\Model\Media;
use Illuminate\Http\Request;
use Ry\Medias\Model\Resizing;
use Illuminate\Support\Facades\File;
use PHPImageWorkshop\ImageWorkshop;
use Gregwar\Image\Image;

class PublicController extends Controller
{
	public function getResize($w, $h, $filename) {
		$w = ceil(floatval($w));
		$h = ceil(floatval($h));
		$square = max($w, $h);
		$resizing = Resizing::where("filename", "=", $filename)->where(function($query) use ($square){
			$query->orWhere("width", "=", $square);
			$query->orWhere("height", "=", $square);
		})->orderBy("width", "DESC")->take(1)->get();
		if($resizing->count()==0) {
			$image = ImageWorkshop::initFromPath(public_path("uploads/$filename"), true);
			$image->resizeToFit($square, $square, true);
			$image->save(storage_path("app/$square"), $filename);
	
			$resizing = new Resizing();
			$resizing->filename = $filename;
			$resizing->width = $w;
			$resizing->height = $h;
			$resizing->type = "image";
			$resizing->save();
		}
		return response(file_get_contents(Image::open(storage_path("app/$square/$filename"))->jpeg(80)), 200, ['Content-type' => 'image/jpeg']);
	}
	
	public function getPlaceholder($w, $h) {
		$fontpath = __DIR__ . "/../../assets/fonts/raleway/Raleway-Light.ttf";
		$layer0 = ImageWorkshop::initVirginLayer($w, $h, "#000");
		$layer = ImageWorkshop::initTextLayer("$w x $h", $fontpath, 20);
		$layer0->addLayerOnTop($layer, 20, 20);
		$layer0->save(storage_path("app"), "image.png");
		return response(file_get_contents(storage_path("app/image.png")), 200, ['Content-type' => 'image/png']);
	}
}