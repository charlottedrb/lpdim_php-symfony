<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private ?RouterInterface $router;

    public function render($templateName, $data = []):Response
    {
        $loader = new FilesystemLoader(__DIR__ . "/../../templates");
        $twig = new Environment($loader, [
            'cache' => __DIR__ . "/../../var/cache/",
            'debug' => false,
        ]);

        return new Response($twig->render($templateName, $data));
    }

    public function redirectTo($path):Response{
        return new RedirectResponse($path);
    }

    /**
     * @return RouterInterface|null
     */
    public function getRouter(): ?RouterInterface
    {
        return $this->router;
    }

    /**
     * @param RouterInterface|null $router
     */
    public function setRouter(?RouterInterface $router): void
    {
        $this->router = $router;
    }
}