<?php

namespace Ahmed\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ahmed\BlogBundle\Entity\Contact;
use Ahmed\BlogBundle\Form\ContactType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller {

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="contact")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('AhmedBlogBundle:Contact')->findAll();

            return array(
                'entities' => $entities,
            );
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Creates a new Contact entity.
     *
     * @Route("/", name="contact_create")
     * @Method("POST")
     * @Template("AhmedBlogBundle:Contact:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Contact();
        $form = $this->createCreateForm($entity);

        if ($request->query->get('authorId')) {
            //get author email
            $authorId = $request->query->get('authorId');
            $em = $this->getDoctrine()->getManager();
            $userEntity = $em->getRepository('AhmedBlogBundle:User')->find($authorId);
            $receiptantEmail = $userEntity->getEmail();
        } else {
            // contact us message so send to admin email
            $receiptantEmail = $this->container->getParameter('admin_email');
        }
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //send email of contact us
            $message = \Swift_Message::newInstance()
                    ->setSubject($entity->getSubject())
                    ->setFrom($entity->getSenderEmail())
                    ->setTo($receiptantEmail)
                    ->setBody($entity->getMessage(), 'text/html');
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('main_page'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Contact entity.
     *
     * @param Contact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Contact $entity) {
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('contact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Contact();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

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
     * Creates a form to edit a Contact entity.
     *
     * @param Contact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Contact $entity) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createForm(new ContactType(), $entity, array(
                'action' => $this->generateUrl('contact_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

            $form->add('submit', 'submit', array('label' => 'Update'));

            return $form;
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}", name="contact_update")
     * @Method("PUT")
     * @Template("AhmedBlogBundle:Contact:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AhmedBlogBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('contact_edit', array('id' => $id)));
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
     * Deletes a Contact entity.
     *
     * @Route("/{id}", name="contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        if (TRUE === $this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AhmedBlogBundle:Contact')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Contact entity.');
                }

                $em->remove($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('contact'));
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * Creates a form to delete a Contact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {

        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('contact_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * send a message to admin.
     *
     * @Route("/contactAuthor/{authorId}", name="contact_author")
     * @Method("GET")
     * @Template()
     */
    public function contactAuthorAction($authorId) {
        //get User Entity
        $em = $this->getDoctrine()->getManager();
        $userEntity = $em->getRepository('AhmedBlogBundle:User')->find($authorId);


        $entity = new Contact();

        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('contact_create', array('authorId' => $authorId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));


        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'user' => $userEntity,
        );
    }

}
