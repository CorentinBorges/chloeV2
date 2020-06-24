<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $alt;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fileName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $portfolio = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $papier = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numerique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getPortfolio(): ?int
    {
        return $this->portfolio;
    }

    public function setPortfolio(?int $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getPapier(): ?int
    {
        return $this->papier;
    }

    public function setPapier(?int $papier): self
    {
        $this->papier = $papier;

        return $this;
    }

    public function getNumerique(): ?int
    {
        return $this->numerique;
    }

    public function setNumerique(?int $numerique): self
    {
        $this->numerique = $numerique;

        return $this;
    }
}
