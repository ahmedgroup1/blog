<?php

namespace Ahmed\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ahmed\BlogBundle\Entity\Category;
use Ahmed\BlogBundle\Form\CategoryType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller {

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AhmedBlogBundle:Category')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/", name="category_create")
     * @Method("POST")
     * @Template("AhmedBlogBundle:Category:new.html.twig")
     */
    public function createAction(Request $request) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $entity = new Category();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
            }

            return array(
                'entity' => $entity,
                'form' => $form->createView(),
            );
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createForm(new CategoryType(), $entity, array(
                'action' => $this->generateUrl('category_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Create'));

            return $form;
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $entity = new Category();
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
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AhmedBlogBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $postEntities = $em->getRepository('AhmedBlogBundle:Post')->findAll();
        $categoryEntities = $em->getRepository('AhmedBlogBundle:Category')->findAll();

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'postEntities' => $postEntities,
            'categoryEntities' => $categoryEntities,
            'delete_form' => $deleteForm->createView(),
            'posts' => $entity->getPosts(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
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
     * Creates a form to edit a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Category $entity) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createForm(new CategoryType(), $entity, array(
                'action' => $this->generateUrl('category_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

            $form->add('submit', 'submit', array('label' => 'Update'));

            return $form;
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="category_update")
     * @Method("PUT")
     * @Template("AhmedBlogBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
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
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AhmedBlogBundle:Category')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Category entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('category'));
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('category_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
