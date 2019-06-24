<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameuser;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameuser(): ?string
    {
        return $this->nameuser;
    }

    public function setNameuser(?string $nameuser): self
    {
        $this->nameuser = $nameuser;

        return $this;
    }

    
    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
    
    public function __toString(){
        return $this->nameuser;
    }

}
