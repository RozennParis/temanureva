<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 * @UniqueEntity(fields="email", message="Cette email est déjà utilisé")
 */
class Newsletter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $subscribingDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getSubscribingDate(): ?\DateTimeInterface
    {
        return $this->subscribingDate;
    }

    public function setAddingDate(\DateTimeInterface $subscribingDate): self
    {
        $this->subscribingDate = $subscribingDate;

        return $this;
    }
}
