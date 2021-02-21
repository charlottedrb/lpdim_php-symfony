<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Score;
use App\FakeData;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ScoreController extends AbstractController
{


    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$scores = FakeData::scores();
        //$games = FakeData::games();
        //$players = FakeData::players();

        $games = $entityManager->getRepository(Game::class)->findAll();
        $players = $entityManager->getRepository(Player::class)->findAll();
        $scores = $entityManager->getRepository(Score::class)->findAll();

        return $this->render("score/index.html.twig", ["scores" => $scores,
            "games" => $games, "players" => $players]);
    }

    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            $game = $entityManager->getRepository(Game::class)->findOneBy(['id' => $request->get('game')]);
            $player = $entityManager->getRepository(Player::class)->findOneBy(['id' => $request->get('player')]);
            $score = new Score();
            $createdAt = new DateTime('NOW');
            $score->setGame($game);
            $score->setPlayer($player);
            $score->setScore($request->get('score'));
            $score->setCreatedAt($createdAt);

            $entityManager->persist($score);
            $entityManager->flush();
            return $this->redirectTo("/score");
        }

        $scores = $entityManager->getRepository(Score::class)->findAll();
        return $this->render("score/index.html.twig", ["err" => "Il y a eu une erreur.", "scores" => $scores]);
    }

    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $score = $entityManager->getRepository(Score::class)->findOneBy(['id' => $id]);
        $entityManager->remove($score);
        $entityManager->flush();
        return $this->redirectTo("/score");
    }

}