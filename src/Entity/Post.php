<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $txt;
    
        /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $txt2;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */ 
    private $user;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;    
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post", cascade={"remove"}))
     */ 
    private $comments; 
    
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTxt(): ?string
    {
        return $this->txt;
    }

    public function setTxt(?string $txt): self
    {
        $this->txt = $txt;

        return $this;
    }
    
    public function getTxt2(): ?string
    {
        return $this->txt2;
    }

    public function setTxt2(?string $txt): self
    {
        $this->txt2 = $txt;

        return $this;
    }    
    
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * @param comment $comment
     */
    public function addComment(Comment $comment)
    {
        if ($this->comments->contains($comment)) {
            return;
        }
        $this->comments->add($comment);
    }
    /**
     * @param comment $comment
     */
    public function removeComment(Comment $comment)
    {
        if (!$this->comments->contains($comment)) {
            return;
        }
        $this->comments->removeElement($comment);
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
    
    
    
}
