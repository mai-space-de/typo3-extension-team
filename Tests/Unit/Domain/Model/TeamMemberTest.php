<?php

declare(strict_types=1);

namespace Maispace\MaiTeam\Tests\Unit\Domain\Model;

use Maispace\MaiTeam\Domain\Model\TeamMember;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

final class TeamMemberTest extends TestCase
{
    // ── Default values ──────────────────────────────────────────────────────

    #[Test]
    public function defaultFirstNameIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getFirstName());
    }

    #[Test]
    public function defaultLastNameIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getLastName());
    }

    #[Test]
    public function defaultRoleIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getRole());
    }

    #[Test]
    public function defaultBioIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getBio());
    }

    #[Test]
    public function defaultEmailIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getEmail());
    }

    #[Test]
    public function defaultPhoneIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getPhone());
    }

    #[Test]
    public function defaultLinkedinIsEmptyString(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getLinkedin());
    }

    #[Test]
    public function defaultSortingIsZero(): void
    {
        $member = new TeamMember();
        self::assertSame(0, $member->getSorting());
    }

    #[Test]
    public function defaultImageIsNull(): void
    {
        $member = new TeamMember();
        self::assertNull($member->getImage());
    }

    #[Test]
    public function defaultCategoriesIsNull(): void
    {
        $member = new TeamMember();
        self::assertNull($member->getCategories());
    }

    // ── initializeObject ────────────────────────────────────────────────────

    #[Test]
    public function initializeObjectSetsCategoriesAsObjectStorage(): void
    {
        $member = new TeamMember();
        $member->initializeObject();
        self::assertInstanceOf(ObjectStorage::class, $member->getCategories());
    }

    #[Test]
    public function initializeObjectCreatesFreshEmptyObjectStorage(): void
    {
        $member = new TeamMember();
        $member->initializeObject();
        self::assertCount(0, $member->getCategories());
    }

    #[Test]
    public function initializeObjectCreatesFreshObjectStorageOnEachCall(): void
    {
        $member = new TeamMember();
        $member->initializeObject();
        $first = $member->getCategories();
        $member->initializeObject();
        self::assertNotSame($first, $member->getCategories());
    }

    // ── firstName getter / setter ───────────────────────────────────────────

    #[Test]
    public function setFirstNameStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Jane');
        self::assertSame('Jane', $member->getFirstName());
    }

    #[Test]
    public function setFirstNameOverwritesPreviousValue(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Jane');
        $member->setFirstName('John');
        self::assertSame('John', $member->getFirstName());
    }

    #[Test]
    public function setFirstNameAcceptsEmptyString(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Jane');
        $member->setFirstName('');
        self::assertSame('', $member->getFirstName());
    }

    // ── lastName getter / setter ────────────────────────────────────────────

    #[Test]
    public function setLastNameStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setLastName('Doe');
        self::assertSame('Doe', $member->getLastName());
    }

    #[Test]
    public function setLastNameOverwritesPreviousValue(): void
    {
        $member = new TeamMember();
        $member->setLastName('Smith');
        $member->setLastName('Doe');
        self::assertSame('Doe', $member->getLastName());
    }

    // ── getFullName ─────────────────────────────────────────────────────────

    #[Test]
    public function getFullNameReturnsBothNamesWithSpace(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Jane');
        $member->setLastName('Doe');
        self::assertSame('Jane Doe', $member->getFullName());
    }

    #[Test]
    public function getFullNameReturnsOnlyFirstNameWhenLastNameIsEmpty(): void
    {
        $member = new TeamMember();
        $member->setFirstName('Jane');
        self::assertSame('Jane', $member->getFullName());
    }

    #[Test]
    public function getFullNameReturnsOnlyLastNameWhenFirstNameIsEmpty(): void
    {
        $member = new TeamMember();
        $member->setLastName('Doe');
        self::assertSame('Doe', $member->getFullName());
    }

    #[Test]
    public function getFullNameReturnsEmptyStringWhenBothNamesAreEmpty(): void
    {
        $member = new TeamMember();
        self::assertSame('', $member->getFullName());
    }

    // ── role getter / setter ────────────────────────────────────────────────

    #[Test]
    public function setRoleStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setRole('Developer');
        self::assertSame('Developer', $member->getRole());
    }

    #[Test]
    public function setRoleAcceptsEmptyString(): void
    {
        $member = new TeamMember();
        $member->setRole('Developer');
        $member->setRole('');
        self::assertSame('', $member->getRole());
    }

    // ── bio getter / setter ─────────────────────────────────────────────────

    #[Test]
    public function setBioStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setBio('Short biography here.');
        self::assertSame('Short biography here.', $member->getBio());
    }

    #[Test]
    public function setBioAcceptsEmptyString(): void
    {
        $member = new TeamMember();
        $member->setBio('Some bio');
        $member->setBio('');
        self::assertSame('', $member->getBio());
    }

    // ── email getter / setter ───────────────────────────────────────────────

    #[Test]
    public function setEmailStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setEmail('jane.doe@example.com');
        self::assertSame('jane.doe@example.com', $member->getEmail());
    }

    #[Test]
    public function setEmailAcceptsEmptyString(): void
    {
        $member = new TeamMember();
        $member->setEmail('jane@example.com');
        $member->setEmail('');
        self::assertSame('', $member->getEmail());
    }

    // ── phone getter / setter ───────────────────────────────────────────────

    #[Test]
    public function setPhoneStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setPhone('+49 123 456789');
        self::assertSame('+49 123 456789', $member->getPhone());
    }

    #[Test]
    public function setPhoneAcceptsEmptyString(): void
    {
        $member = new TeamMember();
        $member->setPhone('+49 123 456789');
        $member->setPhone('');
        self::assertSame('', $member->getPhone());
    }

    // ── linkedin getter / setter ────────────────────────────────────────────

    #[Test]
    public function setLinkedinStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setLinkedin('https://linkedin.com/in/janedoe');
        self::assertSame('https://linkedin.com/in/janedoe', $member->getLinkedin());
    }

    #[Test]
    public function setLinkedinAcceptsEmptyString(): void
    {
        $member = new TeamMember();
        $member->setLinkedin('https://linkedin.com/in/janedoe');
        $member->setLinkedin('');
        self::assertSame('', $member->getLinkedin());
    }

    // ── sorting getter / setter ─────────────────────────────────────────────

    #[Test]
    public function setSortingStoresTheValue(): void
    {
        $member = new TeamMember();
        $member->setSorting(5);
        self::assertSame(5, $member->getSorting());
    }

    #[Test]
    public function setSortingAcceptsZero(): void
    {
        $member = new TeamMember();
        $member->setSorting(10);
        $member->setSorting(0);
        self::assertSame(0, $member->getSorting());
    }

    // ── categories getter / setter ──────────────────────────────────────────

    #[Test]
    public function setCategoriesStoresTheObjectStorage(): void
    {
        $member = new TeamMember();
        $member->initializeObject();
        $storage = new ObjectStorage();
        $member->setCategories($storage);
        self::assertSame($storage, $member->getCategories());
    }

    #[Test]
    public function twoTeamMemberInstancesHaveIndependentCategoryStorages(): void
    {
        $member1 = new TeamMember();
        $member1->initializeObject();
        $member2 = new TeamMember();
        $member2->initializeObject();
        self::assertNotSame($member1->getCategories(), $member2->getCategories());
    }
}
