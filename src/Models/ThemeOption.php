<?php namespace Edutalk\Base\ThemesManagement\Models;

use Edutalk\Base\ThemesManagement\Models\Contracts\ThemeOptionModelContract;
use Edutalk\Base\Models\EloquentBase as BaseModel;

class ThemeOption extends BaseModel implements ThemeOptionModelContract
{
    protected $table = 'theme_options';

    protected $primaryKey = 'id';

    protected $fillable = [
        'theme_id',
        'key',
        'value'
    ];

    public $timestamps = false;

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
