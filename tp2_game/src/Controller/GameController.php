<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use App\FakeData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractController
{

    public function index(EntityManagerInterface $entityManager): Response
    {
        //$fake = FakeData::games(2);
        $games = $entityManager->getRepository(Game::class)->findAll();
        return $this->render("game/index", ["games" => $games]);
    }

    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = FakeData::games(1)[0];
        $players = $entityManager->getRepository(Player::class)->findAll();
        if ($request->getMethod() == Request::METHOD_POST) {
            $game = new Game();
            $game->setName($request->get('name'));
            $game->setImage($request->get('image'));

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectTo("/game");
        }
        return $this->render("game/form", ["game" => $game, "players" => $players]);
    }


    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(["id" => $id]);
        return $this->render("game/show", ["game" => $game]);
    }


    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(["id" => $id]);
        $players = $entityManager->getRepository(Player::class)->findAll();
        if ($request->getMethod() == Request::METHOD_POST) {
            $game->setName($request->get('name'));
            $game->setImage($request->get('image'));
            $player = $entityManager->getRepository(Player::class)->findOneBy(['username' => $request->get('owner')]);
            $game->setPlayer($player);

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectTo("/game");
        }
        return $this->render("game/form", ["game" => $game, "players" => $players]);


    }

    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(['id' => $id]);
        $entityManager->remove($game);
        $entityManager->flush();
        return $this->redirectTo("/game");

    }

}