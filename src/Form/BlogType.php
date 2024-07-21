<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Category;
use App\Form\DataTransformer\TagTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    public function __construct(private readonly TagTransformer $transformer)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'help' => 'Заголовок текста, то что цепляет внимание и отражает суть',
                'attr' => [
                    'class' => 'myclass'
                ]
            ])
            ->add('description', TextareaType::class)
            ->add('text', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function ($repository) {
                  return $repository->createQueryBuilder('p')->orderBy('p.name', 'DESC');
                },
                'choice_label' => 'name',
                'required' => false,
                'empty_data' => '',
                'placeholder' => '',
                'help' => 'можно пустым оставить'
            ])
            ->add('tags', TextType::class, array(
                'label' => 'Теги',
                'required' => false,
            ))
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'pending' => 'pending',
                    'active' => 'active',
                    'blocked' => 'blocked',
                ],
                'placeholder' => ''
            ]);

        $builder->get('tags')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
