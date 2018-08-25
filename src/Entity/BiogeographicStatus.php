<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BiogeographicStatusRepository")
 */
class BiogeographicStatus
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=10)
     * //represents the biogeographic status
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
