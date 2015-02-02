<?php namespace Pingpong\Testing;

use Illuminate\Http\Request;
use Illuminate\Config\Repository;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Facade;
use Illuminate\Foundation\Application;
use Illuminate\Config\EnvironmentVariables;
use Illuminate\Foundation\Testing\AssertionsTrait;
use Illuminate\Foundation\Testing\ApplicationTrait;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase {

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = new Application($this->getApplicationPath());

        $this->resolveHttpKernel($app);

        $this->resolveConsoleKernel($app);

        $this->resolveExceptionsHandler($app);

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->registerBootedCallback($app);

        return $app;
    }

    protected function resolveHttpKernel($app)
    {        
        $app->singleton(
            'Illuminate\Contracts\Http\Kernel',
            'Pingpong\Testing\Http\Kernel'
        );
    }

    protected function resolveConsoleKernel($app)
    {
        $app->singleton(
            'Illuminate\Contracts\Console\Kernel',
            'Pingpong\Testing\Console\Kernel'
        );
    }

    protected function resolveExceptionsHandler($app)
    {
        $app->singleton(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            'Pingpong\Testing\Exceptions\Handler'
        );        
    }

    /**
     * @return array
     */
    protected function getApplicationPath()
    {
        return __DIR__.'/../../fixture/';
    }

    /**
     * @param $app
     */
    protected function registerBootedCallback($app)
    {
        //
    }

}
