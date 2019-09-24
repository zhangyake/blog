<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Area
 *
 * @property int $id
 * @property int $parent_id 上级id,id=0的表示上级是中国
 * @property int $code 区域编码
 * @property string $name 区域名称
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Area[] $children
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereParentId($value)
 * @mixin \Eloquent
 */
class Area extends Model
{
    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(Area::class, 'parent_id', 'id');
    }

    public $timestamps = false;
}
