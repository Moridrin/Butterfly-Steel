<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Campaign
 *
 * @property int $id
 * @property string $title
 * @property int|null $map_id
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereMapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Campaign whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $user_id
 */
class Campaign extends Model
{
    protected $fillable = ['title','map_id','description', 'user_id'];
}
