<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestimonialsController extends Controller
{
  
    /**
     * @Route("/testimonials", name="testimonilspage")
     */
    public function aboutAction(Request $request)
    {
       
        // replace this example code with whatever you need
        return $this->render('default/testimonials.html.twig');
    }
}
