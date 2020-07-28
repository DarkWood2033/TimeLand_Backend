<?php

namespace App\Repositories\Support;

use App\Entities\Support;
use App\Repositories\Repository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSupportRepository extends Repository implements SupportRepository
{
    public function create($name, $email, $subject, $message): Support
    {
        $support = new Support($name, $email, $subject, $message);

        $this->em->persist($support);
        $this->em->flush();

        return $support;
    }

    public function update(Support $support): void
    {
        $this->clearResultCache();
        $this->em->merge($support);
        $this->em->flush();
    }

    public function remove(Support $support): void
    {
        $this->clearResultCache();
        $this->em->remove($support);
        $this->em->flush();
    }

    public function getEdit($id): ?Support
    {
        return $this->createQBWithAssociation()
            ->where('support.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

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
        return 'support';
    }
}
