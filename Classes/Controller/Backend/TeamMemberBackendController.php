<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Controller\Backend;

use Maispace\MaiBase\Controller\Backend\AbstractBackendController;
use Maispace\MaiBase\Controller\Traits\ResponseHelpersTrait;
use Maispace\MaiTeam\Domain\Repository\TeamMemberRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;

#[AsController]
class TeamMemberBackendController extends AbstractBackendController
{
    use ResponseHelpersTrait;

    public function __construct(
        ModuleTemplateFactory $moduleTemplateFactory,
        IconFactory $iconFactory,
        private readonly TeamMemberRepository $teamMemberRepository,
    ) {
        parent::__construct($moduleTemplateFactory, $iconFactory);
    }

    public function indexAction(): ResponseInterface
    {
        $moduleTemplate = $this->createModuleTemplate();

        $this->assignMultiple($moduleTemplate, [
            'teamMembers' => $this->teamMemberRepository->findAll(),
        ]);

        return $this->renderModuleResponse($moduleTemplate, 'Index');
    }

    public function exportCsvAction(): ResponseInterface
    {
        $teamMembers = $this->teamMemberRepository->findAll();

        $rows = [['first_name', 'last_name', 'role', 'email', 'phone', 'linkedin']];
        foreach ($teamMembers as $member) {
            $rows[] = [
                $member->getFirstName(),
                $member->getLastName(),
                $member->getRole(),
                $member->getEmail(),
                $member->getPhone(),
                $member->getLinkedin(),
            ];
        }

        return $this->csvResponse($rows, 'team-members.csv');
    }
}
