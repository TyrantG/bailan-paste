<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Content
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $language 语言
 * @property string $content 内容
 * @property string|null $password 密码
 * @property string|null $unique_path 唯一地址
 * @property int $count_limit 限制浏览次数
 * @property int $time_limit 限制浏览时间
 * @property int $is_destroy 是否可销毁 0不可销毁 1可销毁
 * @property int $user_id 提交用户
 * @property int $views 浏览量
 * @property string|null $ip 提交ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Query\Builder|Content onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCountLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereIsDestroy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUniquePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|Content withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Content withoutTrashed()
 */
class Content extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $fillable = [
        'language', 'content', 'password', 'unique_path', 'count_limit', 'time_limit', 'is_destroy', 'user_id', 'ip', 'views'
    ];
}
