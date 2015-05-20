<?php

namespace Ahmed\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main_page")
     * @Template()
     */
    public function indexAction()
    {
       
        $em = $this->getDoctrine()->getManager();

        $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
        $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();

        return array(
            'postEntities' => $postEntities,
            'categoryEntities' => $categoryEntities 
        );
        
        
    }
}
