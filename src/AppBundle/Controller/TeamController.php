<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends Controller
{
  
    /**
     * @Route("/team", name="teampage")
     */
    public function aboutAction(Request $request)
    {
       
        // replace this example code with whatever you need
        return $this->render('default/team.html.twig');
    }
}
