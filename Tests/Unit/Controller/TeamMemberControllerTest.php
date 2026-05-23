<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Tests\Unit\Controller;

use Maispace\MaiBase\Controller\AbstractActionController;
use Maispace\MaiTeam\Controller\TeamMemberController;
use Maispace\MaiTeam\Domain\Model\TeamMember;
use Maispace\MaiTeam\Domain\Repository\TeamMemberRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

final class TeamMemberControllerTest extends TestCase
{
    #[Test]
    public function controllerExtendsAbstractActionController(): void
    {
        self::assertTrue(
            is_subclass_of(TeamMemberController::class, AbstractActionController::class),
        );
    }

    #[Test]
    public function constructorRequiresTeamMemberRepository(): void
    {
        $params = (new \ReflectionMethod(TeamMemberController::class, '__construct'))
            ->getParameters();

        $names = array_map(static fn(\ReflectionParameter $p) => $p->getName(), $params);
        self::assertContains('teamMemberRepository', $names);

        $repoParam = array_values(array_filter(
            $params,
            static fn(\ReflectionParameter $p) => $p->getName() === 'teamMemberRepository',
        ))[0];

        $type = $repoParam->getType();
        self::assertInstanceOf(\ReflectionNamedType::class, $type);
        self::assertSame(TeamMemberRepository::class, $type->getName());
    }

    #[Test]
    public function listActionMethodExists(): void
    {
        self::assertTrue(
            method_exists(TeamMemberController::class, 'listAction'),
        );
    }

    #[Test]
    public function listActionReturnsResponseInterface(): void
    {
        $returnType = (new \ReflectionMethod(TeamMemberController::class, 'listAction'))
            ->getReturnType();

        self::assertInstanceOf(\ReflectionNamedType::class, $returnType);
        self::assertSame(ResponseInterface::class, $returnType->getName());
    }

    #[Test]
    public function detailActionMethodExists(): void
    {
        self::assertTrue(
            method_exists(TeamMemberController::class, 'detailAction'),
        );
    }

    #[Test]
    public function detailActionReturnsResponseInterface(): void
    {
        $returnType = (new \ReflectionMethod(TeamMemberController::class, 'detailAction'))
            ->getReturnType();

        self::assertInstanceOf(\ReflectionNamedType::class, $returnType);
        self::assertSame(ResponseInterface::class, $returnType->getName());
    }

    #[Test]
    public function detailActionAcceptsNullableTeamMemberParameter(): void
    {
        $params = (new \ReflectionMethod(TeamMemberController::class, 'detailAction'))
            ->getParameters();

        $names = array_map(static fn(\ReflectionParameter $p) => $p->getName(), $params);
        self::assertContains('teamMember', $names);

        $memberParam = array_values(array_filter(
            $params,
            static fn(\ReflectionParameter $p) => $p->getName() === 'teamMember',
        ))[0];

        $type = $memberParam->getType();
        self::assertInstanceOf(\ReflectionNamedType::class, $type);
        self::assertSame(TeamMember::class, $type->getName());
        self::assertTrue($type->allowsNull());
    }
}
