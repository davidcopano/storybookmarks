<?php

namespace MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookmarkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, ['required' => true])
                ->add('url', UrlType::class, ['required' => true])
                ->add('color', ColorType::class, ['required' => false])
                ->add('note', TextareaType::class, ['required' => false])
                ->add('tag', EntityType::class, ['class' => 'MainBundle\Entity\Tag', 'required' => false, 'choices' => $options['data']['tags'], 'placeholder' => 'new_bookmark.fields.no_tag'])
                ->add('folder', EntityType::class, ['class' => 'MainBundle\Entity\Folder', 'required' => false, 'choices' => $options['data']['folders'], 'placeholder' => 'new_bookmark.fields.no_folder'])
                ->add('public', CheckboxType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Bookmark'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_bookmark';
    }


}
