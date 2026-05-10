<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Controller;

use Maispace\MaiBase\Controller\AbstractActionController;
use Maispace\MaiBase\Controller\Traits\PaginationTrait;
use Maispace\MaiTeam\Domain\Model\TeamMember;
use Maispace\MaiTeam\Domain\Repository\TeamMemberRepository;
use Psr\Http\Message\ResponseInterface;

class TeamMemberController extends AbstractActionController
{
    use PaginationTrait;

    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        $settings = $this->getSettings();
        $limit = (int)($settings['listLimit'] ?? 12);

        $teamMembers = $this->teamMemberRepository->findAll();
        $pagination = $this->paginateQueryResult($teamMembers, $this->request, $limit);

        $this->view->assignMultiple([
            'teamMembers' => $pagination['paginatedItems'],
            'pagination' => $pagination['pagination'],
        ]);

        return $this->htmlResponse();
    }

    public function detailAction(?TeamMember $teamMember = null): ResponseInterface
    {
        if ($teamMember === null) {
            return $this->redirect('list');
        }

        $this->view->assign('teamMember', $teamMember);

        return $this->htmlResponse();
    }
}
