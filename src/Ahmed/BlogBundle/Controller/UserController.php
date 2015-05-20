<?php

namespace Ahmed\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller {

    /**
     * Login
     *
     * @Route("/login", name="site_login")
     * @Template()
     */
    public function loginAction() {
        $em = $this->getDoctrine()->getManager();
        $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
        $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();
        return array(
            'postEntities' => $postEntities,
            'categoryEntities' => $categoryEntities,
        );
    }

    /**
     * Register
     *
     * @Route("/register", name="site_register")
     * @Template()
     */
    public function registerAction() {
        $em = $this->getDoctrine()->getManager();
        $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
        $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();
        return array(
            'postEntities' => $postEntities,
            'categoryEntities' => $categoryEntities,
        );
    }

}
