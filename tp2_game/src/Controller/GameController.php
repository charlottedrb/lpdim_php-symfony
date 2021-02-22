<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/games",name:"games")]
class GameController extends AbstractController
{

    #[Route("", name:"game_index")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //$fake = FakeData::games(2);
        $games = $entityManager->getRepository(Game::class)->findAll();
        return $this->render("game/index.html.twig", ["games" => $games]);
    }


    #[Route("/add", name:"game_add", methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = null;
        $players = $entityManager->getRepository(Player::class)->findAll();
        if ($request->getMethod() == Request::METHOD_POST) {
            $game = new Game();
            $game->setName($request->get('name'));
            $game->setImage($request->get('image'));

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectTo("/game");
        }
        return $this->render("game/form.html.twig", ["game" => $game, "players" => $players]);
    }


    #[Route("/show/{id}", name:"game_show", methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(["id" => $id]);
        return $this->render("game/show.html.twig", ["game" => $game]);
    }


    #[Route("/edit/{id}", name:"game_edit", methods: ['POST, GET'])]
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
        return $this->render("game/form.html.twig", ["game" => $game, "players" => $players]);


    }


    #[Route("/delete/{id}",name:"game_delete")]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(['id' => $id]);
        $entityManager->remove($game);
        $entityManager->flush();
        return $this->redirectTo("/game");

    }

}