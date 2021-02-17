<?php


namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="games")
 */
class Game {
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", unique=true, nullable=false)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $image;


    /**
     * @var Collection|Player
     * @ORM\ManyToMany(targetEntity="Player", inversedBy="games")
     */
    private $players;

    /**
     * @var Collection|Score
     * @ORM\OneToMany(targetEntity="Score", mappedBy="game")
     */
    private $scores;


    public function __construct()
    {
        $this->players = new ArrayCollection();
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
     * @param mixed $name
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param mixed $image
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player): self
    {
        $this->players = $player;
        return $this;
    }

    public function getPlayer() : Collection
    {
        return $this->players;
    }

    /**
     * @param Score $score
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