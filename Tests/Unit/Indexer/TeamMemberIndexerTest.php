<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Tests\Unit\Indexer;

use Maispace\MaiSearch\Domain\Service\SearchBackendInterface;
use Maispace\MaiSearch\Service\BackendRegistry;
use Maispace\MaiTeam\Domain\Model\TeamMember;
use Maispace\MaiTeam\Indexer\TeamMemberIndexer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TeamMemberIndexerTest extends TestCase
{
    private TeamMemberIndexer $subject;
    private BackendRegistry&MockObject $backendRegistry;
    private SearchBackendInterface&MockObject $activeBackend;

    protected function setUp(): void
    {
        $this->subject = new TeamMemberIndexer();

        $this->activeBackend = $this->createMock(SearchBackendInterface::class);
        $this->backendRegistry = $this->createMock(BackendRegistry::class);
        $this->backendRegistry->method('getActive')->willReturn($this->activeBackend);
        $this->subject->injectBackendRegistry($this->backendRegistry);
    }

    #[Test]
    public function removeRecordDelegatesToActiveBackend(): void
    {
        $this->activeBackend
            ->expects(self::once())
            ->method('removeDocument')
            ->with('team', 42);

        $this->subject->removeRecord(42, 'tx_maiteam_team_member');
    }

    #[Test]
    public function removeRecordIsNoOpForUnsupportedTable(): void
    {
        $this->activeBackend->expects(self::never())->method('removeDocument');

        $this->subject->removeRecord(42, 'tx_mainews_news');
    }

    #[Test]
    public function getTypeReturnsTeam(): void
    {
        self::assertSame('team', $this->subject->getType());
    }

    #[Test]
    public function supportsTeamMemberTable(): void
    {
        self::assertTrue($this->subject->supports('tx_maiteam_team_member'));
    }

    #[Test]
    public function doesNotSupportOtherTables(): void
    {
        self::assertFalse($this->subject->supports('tx_mainews_news'));
        self::assertFalse($this->subject->supports('pages'));
        self::assertFalse($this->subject->supports('tt_content'));
    }

    #[Test]
    public function getIconReturnsExpectedValue(): void
    {
        self::assertSame('content-team', $this->subject->getIcon('team'));
    }

    #[Test]
    public function buildContentReturnsFullNameRoleAndBio(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Jane');
        $member->setLastName('Doe');
        $member->setRole('CEO');
        $member->setBio('<p>Leads the <strong>organisation</strong>.</p>');

        $content = $this->invokeBuildContent($member);

        self::assertStringContainsString('Jane Doe', $content);
        self::assertStringContainsString('CEO', $content);
        self::assertStringContainsString('Leads the', $content);
        self::assertStringContainsString('organisation', $content);
        self::assertStringNotContainsString('<p>', $content);
        self::assertStringNotContainsString('<strong>', $content);
    }

    #[Test]
    public function buildContentExcludesEmptyRole(): void
    {
        $member = new TeamMember();
        $member->setFirstName('John');
        $member->setLastName('Smith');
        $member->setRole('');
        $member->setBio('Bio text.');

        $content = $this->invokeBuildContent($member);

        self::assertStringContainsString('John Smith', $content);
        self::assertStringContainsString('Bio text.', $content);
    }

    #[Test]
    public function buildContentExcludesEmptyBio(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Alice');
        $member->setLastName('Brown');
        $member->setRole('Designer');
        $member->setBio('');

        $content = $this->invokeBuildContent($member);

        self::assertStringContainsString('Alice Brown', $content);
        self::assertStringContainsString('Designer', $content);
    }

    #[Test]
    public function buildContentReturnsEmptyStringForNonTeamMemberRecord(): void
    {
        $content = $this->invokeBuildContent(new \stdClass());

        self::assertSame('', $content);
    }

    #[Test]
    public function formatResultReturnsSearchResultWithCorrectType(): void
    {
        $solrDoc = [
            'title_s' => 'Jane Doe',
            'content_t' => 'CEO Leads the organisation.',
            'url_s' => '/team',
            'score' => 2.0,
        ];

        $result = $this->subject->formatResult($solrDoc);

        self::assertSame('team', $result->type);
        self::assertSame('Jane Doe', $result->title);
        self::assertSame('/team', $result->url);
        self::assertSame('content-team', $result->icon);
        self::assertSame(2.0, $result->score);
    }

    #[Test]
    public function formatResultDefaultsToEmptyStringsWhenFieldsAreMissing(): void
    {
        $result = $this->subject->formatResult([]);

        self::assertSame('', $result->title);
        self::assertSame('', $result->url);
        self::assertSame(0.0, $result->score);
        self::assertNull($result->date);
    }

    private function invokeBuildContent(object $record): string
    {
        $reflection = new \ReflectionMethod($this->subject, 'buildContent');
        $reflection->setAccessible(true);

        /** @var string $result */
        return $reflection->invoke($this->subject, $record);
    }
}
