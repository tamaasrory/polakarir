<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Krlove\EloquentModelGenerator\Command\GenerateModelCommand;
use Krlove\EloquentModelGenerator\EloquentModelBuilder;
use App\Providers\Processor\CustomPrimaryKeyProcessor;
use App\Providers\Processor\CustomPropertyProcessor;
use App\Providers\Processor\ExistenceCheckerProcessor;
use App\Providers\Processor\FieldProcessor;
use App\Providers\Processor\NamespaceProcessor;
use App\Providers\Processor\RelationProcessor;
use App\Providers\Processor\TableNameProcessor;

/**
 * Class GeneratorServiceProvider
 * @package Krlove\EloquentModelGenerator\Provider
 */
class GeneratorServiceProvider extends ServiceProvider
{
    /** @var string|mixed  */
    const PROCESSOR_TAG = 'eloquent_model_generator.processor';

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->commands([
            GenerateModelCommand::class,
        ]);

        $this->app->tag([
            ExistenceCheckerProcessor::class,
            FieldProcessor::class,
            NamespaceProcessor::class,
            RelationProcessor::class,
            CustomPropertyProcessor::class,
            TableNameProcessor::class,
            // CustomPrimaryKeyProcessor::class,
        ], self::PROCESSOR_TAG);

        $this->app->bind(EloquentModelBuilder::class, function ($app) {
            return new EloquentModelBuilder($app->tagged(self::PROCESSOR_TAG));
        });
    }
}
