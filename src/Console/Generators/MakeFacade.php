<?php namespace Edutalk\Base\ThemesManagement\Console\Generators;

class MakeFacade extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:facade
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Facade';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/facades/facade.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Facades\\' . $this->argument('name');
    }
}
