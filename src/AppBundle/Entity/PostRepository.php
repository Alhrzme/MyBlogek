<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class PostRepository
 * @package AppBundle\Entity
 */
class PostRepository extends EntityRepository
{
    public function getPostWithComments($id)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->from('AppBundle:Post', 'p')
            ->select('p')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->innerJoin('p.comments', 'AppBundle:Comment');
        return $query->getQuery()->getSingleResult();
    }
}
