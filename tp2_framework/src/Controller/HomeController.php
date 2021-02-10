<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController{

    public function index(Request $request): Response {
        if($request->getMethod() == Request::METHOD_POST){
            return $this->render(
                "home/index",
                [
                    "name" => $request->get('name')
                ]
            );
        }
        return $this->render("home/index");
    }
}
