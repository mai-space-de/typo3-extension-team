<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Domain\Repository;

use Maispace\MaiTeam\Domain\Model\TeamMember;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @extends Repository<TeamMember>
 */
class TeamMemberRepository extends Repository
{
    /**
     * @var array<non-empty-string, 'ASC'|'DESC'>
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
        'lastName' => QueryInterface::ORDER_ASCENDING,
        'firstName' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * @return QueryResultInterface<TeamMember>
     */
    public function findByCategory(int $categoryUid): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching($query->contains('categories', $categoryUid));
        return $query->execute();
    }
}
