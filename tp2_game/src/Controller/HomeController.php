<?php


namespace App\Controller;


use App\Entity\Game;
use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAll();
        dd($games);
        return $this->render("home/index", ["name" => $request->query->get('name'), "bestGames" => $bestGames]);
    }
}