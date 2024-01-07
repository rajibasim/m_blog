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
 * Class Comment
 *
 * @property int $id
 * @property int $blog_id
 * @property int $comment_by
 * @property string $comment
 * @property bool $is_active
 *
 * @package App\Models
 */
class Comment extends Model{
    use HasFactory;
    
	protected $table = 'comments';
	protected $primaryKey = 'id';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
        'comment',
        'blog_id',
        'comment_by',
		'is_active',
	];

	public function commentsby(): BelongsTo{
        return $this->belongsTo(User::class, 'comment_by', 'id');
    }
}
