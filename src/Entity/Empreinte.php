<?php

namespace App\Entity;

use App\Repository\EmpreinteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpreinteRepository::class)
 */
class Empreinte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="empreintes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="empreintes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateempreinte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateretour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }




    public function __construct()
    {
        $this->dateempreinte= new \DateTime('now');
    }

    /**
     * @return \DateTime
     */
    public function getDateempreinte(): \DateTime
    {
        return $this->dateempreinte;
    }

    /**
     * @param \DateTime $dateempreinte
     */
    public function setDateempreinte(\DateTime $dateempreinte): void
    {
        $this->dateempreinte = $dateempreinte;
    }

    /**
     * @return mixed
     */
    public function getDateretour()
    {
        return $this->dateretour;
    }

    /**
     * @param mixed $dateretour
     */
    public function setDateretour($dateretour): void
    {
        $this->dateretour = $dateretour;
    }
}
