<?php

namespace Ahmed\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ahmed\BlogBundle\Entity\ContactRepository")
 */
class Contact {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_email", type="string", length=255)
     */
    private $senderEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set senderEmail
     *
     * @param string $senderEmail
     * @return Contact
     */
    public function setSenderEmail($senderEmail) {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    /**
     * Get senderEmail
     *
     * @return string 
     */
    public function getSenderEmail() {
        return $this->senderEmail;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Contact
     */
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Contact
     */
    public function setSubject($subject) {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject() {
        return $this->subject;
    }

}
