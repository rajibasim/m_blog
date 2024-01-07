<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Location
 *
 * @property int $id
 * @property string $ip_address
 * @property string $locations
 * @property bool $is_active
 *
 * @package App\Models
 */
class Location extends Model{
    use HasFactory;
    
	protected $table = 'locations';
	protected $primaryKey = 'id';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
        'ip_address',
		'locations',
		'is_active',
	];
}
