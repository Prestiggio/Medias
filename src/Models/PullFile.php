<?php 
namespace Ry\Medias\Models;

use Illuminate\Database\Eloquent\Model;
use Ry\Admin\Models\Traits\HasJsonSetup;

class PullFile extends Model
{
    use HasJsonSetup;
    
    protected $table = "ry_medias_pull_files";
    
    public function endpoint() {
        return $this->belongsTo(PullEndpoint::class, 'endpoint_id');
    }
}
?>