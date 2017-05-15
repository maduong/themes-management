<?php namespace Edutalk\Base\ThemesManagement\Repositories;

use Edutalk\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use Edutalk\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;

class ThemeRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator  implements ThemeRepositoryContract
{
    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
