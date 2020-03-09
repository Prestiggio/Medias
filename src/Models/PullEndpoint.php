<?php 
namespace Ry\Medias\Models;

use Illuminate\Database\Eloquent\Model;
use Ry\Admin\Models\Traits\HasJsonSetup;

class PullEndpoint extends Model
{
    use HasJsonSetup;
    
    protected $table = "ry_medias_pull_endpoints";
    
    public function owner() {
        return $this->morphTo();
    }
    
    public function files() {
        return $this->hasMany(PullFile::class, 'endpoint_id');
    }
}
?>