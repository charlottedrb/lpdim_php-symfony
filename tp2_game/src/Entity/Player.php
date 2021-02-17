<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="players")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", unique=true, nullable=false)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var Collection|Game
     * @ORM\OneToMany(targetEntity="Game", mappedBy="players")
     */
    private $games;

    /**
     * @var Collection|Score
     * @ORM\OneToMany(targetEntity="Score", mappedBy="player")
     */
    private $scores;


    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param mixed $username
     */
    public function setUsername($username) : self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @param Game $games
     */
    public function setGame(Game $game): self
    {
        $this->games = $game;
        return $this;
    }


    public function getGames(): Collection
    {
        return $this->games;
    }

    /**
     * @param Score $scores
     */
    public function setScore(Score $score): self
    {
        $this->scores = $score;
        return $this;
    }


    public function getScores(): Collection
    {
        return $this->scores;
    }
}