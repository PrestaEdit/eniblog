<?php

namespace Eni\Blog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class BlogCategoryRepository extends EntityRepository
{
    /**
     * Since RAND() is not available by default in Doctrine and we haven't an extension that
     * adds it we perform the random fetch and sorting programmatically in PHP.
     *
     * @param int $langId
     * @param int $limit
     *
     * @return array
     */
    public function getRandom($langId = 0, $limit = 0)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('c')
            ->addSelect('c')
            ->addSelect('cl')
            ->leftJoin('c.categoryLangs', 'cl')
        ;

        if (0 !== $langId) {
            $qb
                ->andWhere('cl.lang = :langId')
                ->setParameter('langId', $langId)
            ;
        }

        $ids = $this->getAllIds();
        shuffle($ids);
        if ($limit > 0) {
            $ids = array_slice($ids, 0, $limit);
        }
        $qb
            ->andWhere('c.id in (:ids)')
            ->setParameter('ids', $ids)
        ;

        $categories = $qb->getQuery()->getResult();
        uasort($categories, function($a, $b) use ($ids) {
            return array_search($a->getId(), $ids) - array_search($b->getId(), $ids);
        });

        return $categories;
    }

    /**
     * @return array
     */
    public function getAllIds()
    {
        /** @var QueryBuilder $qb */
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c.id')
        ;

        $categories = $qb->getQuery()->getScalarResult();

        return array_map(function($category) {
            return $category['id'];
        }, $categories);
    }

    /**
     * @return array
     */
    public function getAllAsArray($sqlJoin, $sqlFilter, $sqlSort, $sqlLimit)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
        SELECT bc
        FROM \Eni\Blog\Entity\BlogCategory bc
        ' . ($sqlJoin != '' ? $sqlJoin : '') . ' ' . ($sqlFilter != '' ? $sqlFilter : '') . '
        ' . ($sqlSort != '' ? $sqlSort : '') . '
        ');

        // LIMIT need to be added separately
        if ($sqlLimit != '') {
            $sqlLimit = str_replace('LIMIT ', '', $sqlLimit);
            $limits = explode(',', $sqlLimit);
            if (is_array($limits) && count($limits) == 2) {
                $offset = (int)trim($limits[0]);
                $limit = (int)trim($limits[1]);
            } else {
                $offset = 0;
                $limit = (int)trim($limits[0]);
            }
            $query->setFirstResult($offset);
            $query->setMaxResults($limit);
        }

        return $query->getArrayResult();
    }
}
