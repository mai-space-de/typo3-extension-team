<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Tests\Unit\Domain\Repository;

use Maispace\MaiTeam\Domain\Repository\TeamMemberRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

final class TeamMemberRepositoryTest extends TestCase
{
    #[Test]
    public function repositoryExtendsTYPO3BaseRepository(): void
    {
        self::assertTrue(
            is_subclass_of(TeamMemberRepository::class, Repository::class),
            TeamMemberRepository::class . ' must extend ' . Repository::class,
        );
    }

    #[Test]
    public function defaultOrderingsSortBySortingAscending(): void
    {
        $reflection = new \ReflectionClass(TeamMemberRepository::class);
        $defaults = $reflection->getDefaultProperties();

        self::assertArrayHasKey('defaultOrderings', $defaults);
        self::assertIsArray($defaults['defaultOrderings']);
        self::assertArrayHasKey('sorting', $defaults['defaultOrderings']);
        self::assertSame(QueryInterface::ORDER_ASCENDING, $defaults['defaultOrderings']['sorting']);
    }

    #[Test]
    public function defaultOrderingsSortByLastNameAscendingAsSecondKey(): void
    {
        $reflection = new \ReflectionClass(TeamMemberRepository::class);
        $defaults = $reflection->getDefaultProperties();

        self::assertArrayHasKey('defaultOrderings', $defaults);
        self::assertIsArray($defaults['defaultOrderings']);
        self::assertArrayHasKey('lastName', $defaults['defaultOrderings']);
        self::assertSame(QueryInterface::ORDER_ASCENDING, $defaults['defaultOrderings']['lastName']);
    }

    #[Test]
    public function defaultOrderingsSortByFirstNameAscendingAsThirdKey(): void
    {
        $reflection = new \ReflectionClass(TeamMemberRepository::class);
        $defaults = $reflection->getDefaultProperties();

        self::assertArrayHasKey('defaultOrderings', $defaults);
        self::assertIsArray($defaults['defaultOrderings']);
        self::assertArrayHasKey('firstName', $defaults['defaultOrderings']);
        self::assertSame(QueryInterface::ORDER_ASCENDING, $defaults['defaultOrderings']['firstName']);
    }

    #[Test]
    public function defaultOrderingsContainExactlyThreeSortKeys(): void
    {
        $reflection = new \ReflectionClass(TeamMemberRepository::class);
        $defaults = $reflection->getDefaultProperties();

        self::assertCount(3, $defaults['defaultOrderings']);
    }

    #[Test]
    public function defaultOrderingsApplyInCorrectPriorityOrder(): void
    {
        $reflection = new \ReflectionClass(TeamMemberRepository::class);
        $defaults = $reflection->getDefaultProperties();

        self::assertIsArray($defaults['defaultOrderings']);
        $keys = array_keys($defaults['defaultOrderings']);
        self::assertSame(['sorting', 'lastName', 'firstName'], $keys);
    }
}
