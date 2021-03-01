<?php


namespace App\Controller;


use App\Entity\Game;
use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route("/",name:"homepage")]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAll();
        $scores = [];

        // Get all game's scores and add them to make a total score.
        foreach ($games as $game){
            $totalScore = 0;
            foreach ($game->getScores() as $key => $score){
                $totalScore += $score->getScore();
            }
            $scores[$game->getName()] = $totalScore;
        }
        arsort($scores);
        $highestScores = array_slice($scores, 0, 3);

        return $this->render("home/index.html.twig", ["name" => $request->query->get('name'), "highestScores" => $highestScores]);
    }
}