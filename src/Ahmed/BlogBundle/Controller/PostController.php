<?php

namespace Ahmed\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ahmed\BlogBundle\Entity\Post;
use Ahmed\BlogBundle\Form\PostType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Post controller.
 *
 * @Route("/post")
 */
class PostController extends Controller {

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AhmedBlogBundle:Post')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/", name="post_create")
     * @Method("POST")
     * @Template("AhmedBlogBundle:Post:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Post();

        //add date automatially on creation
        $entity->setDateCreated(new \DateTime());
        $entity->setDateUpdated(new \DateTime());
        
        
        $user = $this->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        
        $entity->setAuthor($userId);
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('post_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $entity) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createForm(new PostType(), $entity, array(
                'action' => $this->generateUrl('post_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Create'));

            return $form;
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="post_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $entity = new Post();
            $form = $this->createCreateForm($entity);

            $em = $this->getDoctrine()->getManager();
            $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
            $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();

            return array(
                'entity' => $entity,
                'form' => $form->createView(),
                'postEntities' => $postEntities,
                'categoryEntities' => $categoryEntities,
            );
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AhmedBlogBundle:Post')->find($id);
        
        $userEntity = $em->getRepository('AhmedBlogBundle:User')->find($entity->getAuthor());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
        $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();


        return array(
            'entity' => $entity,
            'postEntities' => $postEntities,
            'categoryEntities' => $categoryEntities,
            'delete_form' => $deleteForm->createView(),
            'user' => $userEntity
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
            $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();

            return array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'postEntities' => $postEntities,
                'categoryEntities' => $categoryEntities,
            );
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Creates a form to edit a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Post $entity) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createForm(new PostType(), $entity, array(
                'action' => $this->generateUrl('post_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

            $form->add('submit', 'submit', array('label' => 'Update'));

            return $form;
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}", name="post_update")
     * @Method("PUT")
     * @Template("AhmedBlogBundle:Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            //update dateUpdated automatially
            $entity->setDateUpdated(new \DateTime());

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);



            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
            }

            return array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AhmedBlogBundle:Post')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Post entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('post'));
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {

        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('post_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
