<?php

namespace Ahmed\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('content', 'textarea', array('max_length' => 255))
                //->add('dateCreated','datetime', array('data' => new \DateTime()))
                //->add('dateUpdated')
                //->add('author')
        ;
        $builder->add('author', 'entity', array(
            'class' => 'AhmedBlogBundle:User',
            'property' => 'username',
        ));
        $builder->add('postToCategories', 'entity', array(
            'class' => 'AhmedBlogBundle:Category',
            'property' => 'name',
        ));
        
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Ahmed\BlogBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ahmed_blogbundle_post';
    }

}
