<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This email address is already registered."
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     message="This username is already taken."
 * )
 */
class User implements AdvancedUserInterface, \Serializable
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Username
     *
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     */
    private $username;

    /**
     * Email
     *
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $email;

    /**
     * First name
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * Last name
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * Phone
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * Address
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * Hashed password
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * User roles
     *
     * @ORM\Column(type="json_array", nullable=false)
     */
    private $roles = [];

    /**
     * Account active status
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":true})
     */
    private $isActive = true;

    /**
     * Email verification status
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     */
    private $isVerified = false;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if (empty($this->roles)) {
            $this->roles = ['ROLE_USER'];
        }
    }

    /* ==========================================
     * Getters and Setters
     * ========================================== */

    public function getId()
    {
        return $this->id;
    }

    // Symfony login identifier
    public function getUsername()
    {
        return $this->email;
    }

    public function getDisplayUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName()
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isVerified()
    {
        return $this->isVerified;
    }

    public function setIsVerified($isVerified)
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /* ==========================================
     * Symfony Security
     * ========================================== */

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function isEnabled()
    {
        return $this->isActive && !$this->isDeleted();
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    /* ==========================================
     * Serializable
     * ========================================== */

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
        ) = unserialize($serialized);
    }
}
