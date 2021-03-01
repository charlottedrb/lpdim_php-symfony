<?php

namespace App\Controller;
use Closure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

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
        $function = new TwigFunction('path', function ($route_name, $route_parameters = []) {
            //var_dump($route_parameters);
            return $this->router->generate($route_name, $route_parameters);
        });
        $twig->addFunction($function);

        return new Response($twig->render($templateName, $data));
    }


    public function redirectTo($path): Response{
        return new RedirectResponse($path);
    }


    public function redirectToRoute($route_name, $route_parameters = []){
        $url = $this->router->generate($route_name, $route_parameters);
        $this->redirectTo($url);
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