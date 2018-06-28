<?php

namespace VC\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class ReferenceFormType
 * @author Martin Patera <mzstic@gmail.com>
 */
class ReferenceFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title', 'text', [
            'label' => 'Název',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('category', 'entity', [
            'label' => 'Kategorie',
            'class' => 'VC\WebBundle\Entity\Category',
            'property' => 'title'
        ]);

        $builder->add('important', 'checkbox', [
            'label' => 'Významná reference',
			'required' => false
        ]);

        $builder->add('building', 'text', [
            'label' => 'Stavba',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('investor', 'text', [
            'label' => 'Investor',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('client', 'text', [
            'label' => 'Klient',
            'attr' => [
                'class' => 'form-control'
            ],
	        'required' => false,
        ]);

        $builder->add('description', 'textarea', [
            'label' => 'Popis',
            'attr' => [
                'class' => 'form-control'
            ],
	        'required' => false,
        ]);

        $builder->add('performances', 'text', [
            'label' => 'Výkony',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('realization', 'text', [
            'label' => 'Realizace',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('investment', 'text', [
            'label' => 'Investice',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('year', 'integer', [
            'label' => 'Rok',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('hip', 'text', [
            'label' => 'HIP',
            'attr' => [
                'class' => 'form-control'
            ],
	        'required' => false,
        ]);

        $builder->add('commission_number', 'text', [
            'label' => 'Č. zakázky',
            'attr' => [
                'class' => 'form-control'
            ],
	        'required' => false,
        ]);


        $builder->add('save','submit', [
            'label' => 'Uložit',
	        'attr' => ['class' => 'btn btn-success'],
        ]);

    }


    public function getName()
    {
        return 'vc_admin_reference';
    }
}