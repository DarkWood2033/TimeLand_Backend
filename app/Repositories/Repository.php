<?php

namespace App\Repositories;

use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class Repository
{
    use ClearsCache;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $er;

    /**
     * @var CachingOptions
     */
    protected $cachingOptions;

    /**
     * DoctrineMusicRepository constructor.
     * @param EntityManagerInterface $em
     * @param EntityRepository $er
     * @param \App\Services\Caching\CachingOptions $cachingOptions
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $er, CachingOptions $cachingOptions)
    {
        $this->em = $em;
        $this->er = $er;
        $this->cachingOptions = $cachingOptions;
    }

    /**
     * @return bool
     */
    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder($this->getAlias())
            ->delete()
            ->getQuery()
            ->getResult();
    }

    protected function createQBWithAssociation($with = [], $indexBy = null)
    {
        $with = array_intersect($this->getAssociation(), $with);
        $qb = $this->er->createQueryBuilder($this->getAlias(), $indexBy)
            ->select(array_merge([$this->getAlias()], $with));

        foreach ($with as $association){
            if(in_array($association, $with)) $qb->leftJoin($this->getAlias().'.'.$association, $association);
        }

        return $qb;
    }

    abstract protected function getAssociation(): array;
    abstract protected function getAlias(): string;
}
