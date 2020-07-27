<?php

namespace App\Repositories\User;

use App\Entities\User;
use App\Repositories\Repository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository extends Repository implements UserRepository
{
    /**
     * @param $name
     * @param $email
     * @param $password
     * @return User
     */
    public function create($name, $email, $password): User
    {
        $user = new User($name, $email, $password);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param User $user
     */
    public function update(User $user): void
    {
        $this->clearResultCache();
        $this->em->merge($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        $this->clearResultCache();
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @param $id
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEdit($id): ?User
    {
        return $this->createQBWithAssociation()
            ->where('user.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    /**
     * @return User[]
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
        return [];
    }

    protected function getAlias(): string
    {
        return 'user';
    }
}
