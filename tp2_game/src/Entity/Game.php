<?php


namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Player", inversedBy="games")
     */
    private $players;

    /**
     * @var Score
     * @ORM\OneToMany(targetEntity="Score", mappedBy="game")
     */
    private $score;


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
    public function setName($name): void
    {
        $this->name = $name;
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
    public function setImage($image): void
    {
        $this->image = $image;
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
    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getPlayer() : Player {
        return $this->player;
    }

    /**
     * @param Score $score
     */
    public function setScore(Score $score): void
    {
        $this->score = $score;
    }

    /**
     * @return Score
     */
    public function getScore(): Score
    {
        return $this->score;
    }
}