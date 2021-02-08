<?php

namespace App\Controller;


use App\Entity\Game;
use App\FakeData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractController
{

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /**
         * @todo lister les jeux de la base
         */
        $gamesFromDB = $entityManager->getRepository(Game::class)->findAll();
        //dd($gamesFromDB);
        $games = FakeData::games(2);
        return $this->render("game/index", ["games" => $games, "gamesDB" => $gamesFromDB]);

    }

    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = FakeData::games(1)[0];
        if ($request->getMethod() == Request::METHOD_POST) {
            /**
             * @todo enregistrer l'objet
             */

            $game = new Game();
            var_dump($request->get('name'));
            $game->setName($request->get('name'));
            $game->setImage($request->get('image'));

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectTo("/game");
        }
        return $this->render("game/form", ["game" => $game]);
    }


    public function show($id): Response
    {
        $game = FakeData::games(1)[0];
        return $this->render("game/show", ["game" => $game]);
    }


    public function edit($id, Request $request): Response
    {
        $game = FakeData::games(1)[0];

        if ($request->getMethod() == Request::METHOD_POST) {
            /**
             * @todo enregistrer l'objet
             */
            return $this->redirectTo("/game");
        }
        return $this->render("game/form", ["game" => $game]);


    }

    public function delete($id): Response
    {
        /**
         * @todo supprimer l'objet
         */
        return $this->redirectTo("/game");

    }

}