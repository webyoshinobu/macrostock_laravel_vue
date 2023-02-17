<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Photo extends Model
{
    // use HasFactory;

    /** プライマリキーの型 */
    protected $keyType = 'string';

    /** IDの桁数 */
    const ID_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (! Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }

    /**
     * ランダムなID値をid属性に代入する
     */
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    /**
     * ランダムなID値を生成する
     * @return string
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for ($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }

    /**
    * リレーションシップ - usersテーブル
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function owner()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id', 'admins');
    }

    /**
    * アクセサ - url
    * @return string
    */
    public function getUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }

    /** JSONに含める属性 */
    protected $appends = [
        'url',
    ];

    // /** JSONに含めない属性 */
    // protected $hidden = [
    //     'user_id', 'filename',
    //     self::CREATED_AT, self::UPDATED_AT,
    // ];

    /** JSONに含める属性 */
    protected $visible = [
        'url', 'price', 'filename', 'owner', 'id'
    ];
}
