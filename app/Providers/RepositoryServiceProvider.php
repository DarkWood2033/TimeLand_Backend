<?php

namespace App\Providers;

use App\Services\Caching\CachingOptions;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if($repositories = config('repository')) {
            foreach ($repositories as $key => $value) {
                $this->app->when($value['concrete'])
                    ->needs(EntityRepository::class)
                    ->give(function () use ($value) {
                        return $this->buildEntityRepository($value['entity']);
                    });
                if (isset($value['caching'])) {
                    $enabled = $value['caching']['enabled'];
                    $lifetime = $value['caching']['lifetime'];

                    $this->app->when($value['concrete'])
                        ->needs(CachingOptions::class)
                        ->give(function () use ($enabled, $lifetime) {
                            return (new CachingOptions($enabled))
                                ->setLifetime($lifetime);
                        });
                }
                $this->app->singleton($key, $value['concrete']);
            }
        }
    }

    private function buildEntityRepository(string $entity)
    {
        return new EntityRepository(
            $this->app->make(EntityManagerInterface::class),
            new ClassMetadata($entity)
        );
    }
}
