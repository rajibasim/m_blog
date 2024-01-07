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
 * Class Blog
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property text $content
 * @property bool $is_active
 *
 * @package App\Models
 */
class Blog extends Model{
    use HasFactory;
    
	protected $table = 'blogs';
	protected $primaryKey = 'id';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
        'content',
        'author_id',
		'is_active',
	];

	public function author(): BelongsTo{
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class, 'blog_id', 'id');
    }
}
