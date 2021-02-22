<?php

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/game",name:"game_")]
class GameController extends AbstractController
{

    #[Route("", name:"index")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //$fake = FakeData::games(2);
        $games = $entityManager->getRepository(Game::class)->findAll();
        return $this->render("game/index.html.twig", ["games" => $games]);
    }


    #[Route("/add", name:"add")]
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $game = null;
        $players = $entityManager->getRepository(Player::class)->findAll();
        if ($request->getMethod() == Request::METHOD_POST) {
            $game = new Game();
            $game->setName($request->get('name'));
            $game->setImage($request->get('image'));

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute("games");
        }
        return $this->render("game/form.html.twig", ["game" => $game, "players" => $players]);
    }


    #[Route("/show/{id}", name:"show")]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(["id" => $id]);
        return $this->render("game/show.html.twig", ["game" => $game]);
    }


    #[Route("/edit/{id}", name:"edit")]
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

            return $this->redirectToRoute("games");
        }
        return $this->render("game/form.html.twig", ["game" => $game, "players" => $players]);


    }


    #[Route("/delete/{id}",name:"delete")]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(['id' => $id]);
        $entityManager->remove($game);
        $entityManager->flush();

        return $this->redirectToRoute("games");
    }

}