<?php

namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $username = "";
        
        if(null !== $user = $this->getUser()){
            $username = $user->getUsername();
        }
        return $this->render('default/index.html.twig', [
            'username' => $username,
        ]);
    }
}