<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Filter\BlogFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('title', TextType::class, [
                'label' => 'Название',
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'label' => 'Описание',
                'required' => false
            ])
            ->add('content', TextType::class, [
                'label' => 'Содержание',
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BlogFilter::class,
            'csrf_protection' => false
        ]);
    }
}
