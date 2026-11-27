<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * Get all users ordered by latest created date.
     */
    public function findAllOrderedByLatest()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find active users.
     */
    public function findActiveUsers()
    {
        return $this->createQueryBuilder('u')
            ->where('u.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find user by email.
     */
    public function findByEmail($email)
    {
        return $this->findOneBy([
            'email' => $email
        ]);
    }

    /**
     * Search users by username, email or name.
     */
    public function searchUsers($keyword)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username LIKE :keyword')
            ->orWhere('u.email LIKE :keyword')
            ->orWhere('u.firstName LIKE :keyword')
            ->orWhere('u.lastName LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
