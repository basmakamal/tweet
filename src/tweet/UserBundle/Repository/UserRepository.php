<?php

namespace tweet\UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository {

    public function getfollowers($user){
        $query = $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->where('s.user_tweets = :user_tweets')
            ->setParameter('user_tweets',$user_tweets)
        ->getQuery();
        return $query->getSingleScalarResult();
    }

}