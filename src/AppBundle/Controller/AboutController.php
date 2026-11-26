<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends Controller
{
  
    /**
     * @Route("/about", name="aboutpage")
     */
    public function aboutAction(Request $request)
    {
       
        // replace this example code with whatever you need
        return $this->render('default/about.html.twig');
    }
}
