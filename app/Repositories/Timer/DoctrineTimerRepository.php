<?php

namespace App\Repositories\Timer;

use App\Entities\Timer;
use App\Entities\User;
use App\Repositories\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class DoctrineTimerRepository extends Repository implements TimerRepository
{
    /**
     * @param $name
     * @param User $user
     * @param array $items
     * @param $type
     * @param $common_time
     * @return Timer
     */
    public function create($name, User $user, array $items, $type, $common_time): Timer
    {
        $timer = new Timer($name, $user, $items, $type, $common_time);

        $this->em->persist($timer);
        $this->em->flush();

        return $timer;
    }

    /**
     * @param Timer $timer
     */
    public function update(Timer $timer): void
    {
        $this->clearResultCache();
        $this->em->merge($timer);
        $this->em->flush();
    }

    /**
     * @param Timer $timer
     */
    public function remove(Timer $timer): void
    {
        $this->clearResultCache();
        $this->em->remove($timer);
        $this->em->flush();
    }

    /**
     * @param $id
     * @return Timer|null
     * @throws NonUniqueResultException
     */
    public function getEdit($id): ?Timer
    {
        return $this->createQBWithAssociation()
            ->where('timer.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    /**
     * @param User $user
     * @param $id
     * @return Timer|null
     * @throws NonUniqueResultException
     */
    public function getEditByUser(User $user, $id): ?Timer
    {
        return $this->createQBWithAssociation()
            ->where('timer.user = :user_id')
            ->setParameter('user_id', $user)
            ->setMaxResults(1)
            ->setFirstResult($id - 1)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    /**
     * @param User $user
     * @return int|mixed|string
     */
    public function getAllByUser(User $user)
    {
        return $this->createQBWithAssociation()
            ->where('timer.user = :user_id')
            ->setParameter('user_id', $user)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    /**
     * @return Timer[]
     */
    public function getAll()
    {
        return $this->createQBWithAssociation()
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    protected function getAssociation(): array
    {
        return ['user'];
    }

    protected function getAlias(): string
    {
        return 'timer';
    }
}
