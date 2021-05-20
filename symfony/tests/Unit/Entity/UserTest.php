<?php


namespace App\Tests\Unit\Entity;


use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function getIdReturnsNull(): void
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    /**
     * @test
     */
    public function setUsernameReturnsUser(): void
    {
        $username = 'username';
        $user = new User();
        $this->assertEquals($user, $user->setUsername($username));
    }

    /**
     * @test
     */
    public function getUsernameReturnsEmptyString(): void
    {
        $user = new User();
        $this->assertEmpty($user->getUsername());
    }

    /**
     * @test
     */
    public function setRolesReturnsUser(): void
    {
        $roles = ['ROLE_TEST'];
        $user = new User();
        $this->assertEquals($user, $user->setRoles($roles));
    }

    /**
     * @test
     */
    public function getRolesReturnsArrayWithRoleUser(): void
    {
        $roles = ['ROLE_USER'];
        $user = new User();
        $this->assertEquals($roles, $user->getRoles());
    }

    /**
     * @test
     */
    public function setEmailReturnsUser(): void
    {
        $email = 'user@example.com';
        $user = new User();
        $this->assertEquals($user, $user->setEmail($email));
    }

    /**
     * @test
     */
    public function getEmailReturnsNull(): void
    {
        $email = null;
        $user = new User();
        $this->assertEquals($email, $user->getEmail());
    }

    /**
     * @test
     */
    public function setPasswordReturnsUser(): void
    {
        $password = 'password';
        $user = new User();
        $this->assertEquals($user, $user->setPassword($password));
    }

    /**
     * @test
     */
    public function getPasswordReturnsEmptyString(): void
    {
        $user = new User();
        $this->assertEmpty($user->getPassword());
    }

    /**
     * @test
     */
    public function getSaltReturnsNull(): void
    {
        $user = new User();
        $this->assertNull($user->getSalt());
    }
}