<?php namespace Edutalk\Base\ThemesManagement\Console\Generators;

class MakeMiddleware extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:middleware
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Middleware';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/middleware/middleware.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Http\\Middleware\\' . $this->argument('name');
    }
}
