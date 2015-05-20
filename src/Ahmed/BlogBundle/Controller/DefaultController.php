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
        return array('name' => 'ddd');
    }
}
