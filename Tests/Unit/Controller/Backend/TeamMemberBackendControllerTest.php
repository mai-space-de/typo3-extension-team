<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Tests\Unit\Controller\Backend;

use Maispace\MaiBase\Controller\Backend\AbstractBackendController;
use Maispace\MaiTeam\Controller\Backend\TeamMemberBackendController;
use Maispace\MaiTeam\Domain\Repository\TeamMemberRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;

final class TeamMemberBackendControllerTest extends TestCase
{
    #[Test]
    public function controllerExtendsAbstractBackendController(): void
    {
        self::assertTrue(
            is_subclass_of(TeamMemberBackendController::class, AbstractBackendController::class),
        );
    }

    #[Test]
    public function constructorDeclaresModuleTemplateFactoryParameter(): void
    {
        $params = (new \ReflectionMethod(TeamMemberBackendController::class, '__construct'))
            ->getParameters();

        $names = array_map(static fn(\ReflectionParameter $p) => $p->getName(), $params);
        self::assertContains('moduleTemplateFactory', $names);

        $factoryParam = array_values(array_filter(
            $params,
            static fn(\ReflectionParameter $p) => $p->getName() === 'moduleTemplateFactory',
        ))[0];

        $type = $factoryParam->getType();
        self::assertInstanceOf(\ReflectionNamedType::class, $type);
        self::assertSame(ModuleTemplateFactory::class, $type->getName());
    }

    #[Test]
    public function constructorDeclaresIconFactoryParameter(): void
    {
        $params = (new \ReflectionMethod(TeamMemberBackendController::class, '__construct'))
            ->getParameters();

        $names = array_map(static fn(\ReflectionParameter $p) => $p->getName(), $params);
        self::assertContains('iconFactory', $names);

        $iconParam = array_values(array_filter(
            $params,
            static fn(\ReflectionParameter $p) => $p->getName() === 'iconFactory',
        ))[0];

        $type = $iconParam->getType();
        self::assertInstanceOf(\ReflectionNamedType::class, $type);
        self::assertSame(IconFactory::class, $type->getName());
    }

    #[Test]
    public function constructorRequiresTeamMemberRepository(): void
    {
        $params = (new \ReflectionMethod(TeamMemberBackendController::class, '__construct'))
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
    public function indexActionMethodExists(): void
    {
        self::assertTrue(
            method_exists(TeamMemberBackendController::class, 'indexAction'),
        );
    }

    #[Test]
    public function indexActionReturnsResponseInterface(): void
    {
        $returnType = (new \ReflectionMethod(TeamMemberBackendController::class, 'indexAction'))
            ->getReturnType();

        self::assertInstanceOf(\ReflectionNamedType::class, $returnType);
        self::assertSame(ResponseInterface::class, $returnType->getName());
    }

    #[Test]
    public function exportCsvActionMethodExists(): void
    {
        self::assertTrue(
            method_exists(TeamMemberBackendController::class, 'exportCsvAction'),
        );
    }

    #[Test]
    public function exportCsvActionReturnsResponseInterface(): void
    {
        $returnType = (new \ReflectionMethod(TeamMemberBackendController::class, 'exportCsvAction'))
            ->getReturnType();

        self::assertInstanceOf(\ReflectionNamedType::class, $returnType);
        self::assertSame(ResponseInterface::class, $returnType->getName());
    }
}
