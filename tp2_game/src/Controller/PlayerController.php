<?php
namespace App\Controller;


use App\Entity\Game;
use App\Entity\Player;
use App\FakeData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/player", name:"player_")]
class PlayerController extends AbstractController
{

    #[Route("", name:"index")]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        //$players = FakeData::players(25);
        $players = $entityManager->getRepository(Player::class)->findAll();
        return $this->render("player/index.html.twig", ["players" => $players]);

    }

    #[Route("/add", name:"add")]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = null;
        if ($request->getMethod() == Request::METHOD_POST) {
            $player = new Player();
            $player->setUsername($request->get('username'));
            $player->setEmail($request->get('email'));

            $entityManager->persist($player);
            $entityManager->flush();
            return $this->redirectTo("/player");
        }
        return $this->render("player/form.html.twig", ["player" => $player]);
    }


    #[Route("/show/{id]", name:"show")]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        //$player = FakeData::players(1)[0];
        $player = $entityManager->getRepository(Player::class)->findOneBy(['id' => $id]);
        return $this->render("player/show.html.twig", ["player" => $player, "availableGames" => FakeData::games()]);
    }


    #[Route("/edit/{id}", name:"edit")]
    public function edit($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = $entityManager->getRepository(Player::class)->findOneBy(['id' => $id]);
        if ($request->getMethod() == Request::METHOD_POST) {
            $player->setUsername($request->get('username'));
            $player->setEmail($request->get('email'));

            $entityManager->persist($player);
            $entityManager->flush();
            return $this->redirectTo("/player");
        }
        return $this->render("player/form.html.twig", ["player" => $player]);
    }


    #[Route("/delete/{id}", name:"delete")]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $player = $entityManager->getRepository(Player::class)->findOneBy(['id' => $id]);
        $entityManager->remove($player);
        $entityManager->flush();
        return $this->redirectTo("/player");

    }


    #[Route("/addgame/{id}", name:"addgame")]
    public function addgame($id, Request $request): Response
    {
        if ($request->getMethod() == Request::METHOD_POST) {
            /**
             * @todo enregistrer l'objet
             */
            return $this->redirectTo("/player");
        }
    }

}
