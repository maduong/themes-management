<?php namespace Edutalk\Base\ThemesManagement\Repositories;

use Edutalk\Base\Caching\Services\Traits\Cacheable;
use Edutalk\Base\Models\Contracts\BaseModelContract;
use Edutalk\Base\Repositories\Eloquent\EloquentBaseRepository;
use Edutalk\Base\Caching\Services\Contracts\CacheableContract;
use Edutalk\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;

class ThemeOptionRepository extends EloquentBaseRepository implements ThemeOptionRepositoryContract, CacheableContract
{
    use Cacheable;

    /**
     * @var mixed|null
     */
    protected $currentTheme;

    /**
     * @param $id
     * @return array
     */
    public function getOptionsByThemeId($id)
    {
        $query = $this->model
            ->join('themes', 'theme_options.theme_id', '=', 'themes.id')
            ->where('themes.id', '=', $id)
            ->select('theme_options.key', 'theme_options.value')
            ->get();
        return $query->pluck('value', 'key')->toArray();
    }

    /**
     * @param $alias
     * @return array
     */
    public function getOptionsByThemeAlias($alias)
    {
        $query = $this->model
            ->join('themes', 'theme_options.theme_id', '=', 'themes.id')
            ->where('themes.alias', '=', $alias)
            ->select('theme_options.key', 'theme_options.value')
            ->get();
        return $query->pluck('value', 'key')->toArray();
    }

    /**
     * @param array $options
     * @return bool
     */
    public function updateOptions($options = [])
    {
        foreach ($options as $key => $row) {
            $result = $this->updateOption($key, $row);
            if (!$result) {
                return $result;
            }
        }
        return true;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateOption($key, $value)
    {
        if (!$this->currentTheme) {
            $this->currentTheme = cms_theme_options()->getCurrentTheme();
        }

        if (!$this->currentTheme) {
            return false;
        }

        $option = $this->model
            ->where([
                'key' => $key,
                'theme_id' => array_get($this->currentTheme, 'id'),
            ])
            ->select(['id', 'key', 'value'])
            ->first();

        $result = $this->createOrUpdate($option, [
            'key' => $key,
            'value' => $value,
            'theme_id' => array_get($this->currentTheme, 'id'),
        ]);

        if (!$result) {
            return false;
        }

        return true;
    }
}
