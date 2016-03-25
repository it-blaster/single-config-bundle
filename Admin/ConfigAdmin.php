<?php

namespace ItBlaster\SingleConfigBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Propel1\Form\Type\TranslationCollectionType;
use Symfony\Bridge\Propel1\Form\Type\TranslationType;

class ConfigAdmin extends Admin
{

    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
        '_per_page'   => 100,
        '_sort_order' => 'ASC',
        '_sort_by' => 'Name'
    );

    protected $perPageOptions = array(20, 50, 100, 500);
    protected $maxPerPage = 100;
    protected $maxPageLinks = 1000;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('title')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('name', null, array(
                'label' => 'Alias',
                'sortable' => true,
            ))
            ->addIdentifier('title', null, array(
                'label' => 'Название',
                'sortable' => true,
            ))
            ->add('value', null, array(
                'label' => 'Значение',
                'sortable' => false,
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                ),
                'label' => 'Редактировать',
                'sortable' => false
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();

        $formMapper
            ->add('name', null, [
                'label' => 'Alias',
                'read_only' => !$em->contains($this->getSubject()),
            ])
            ->add('title', null, [
                'label' => 'Название',
            ])
            ->add('value', 'textarea', [
                'label' => 'Значение',
                'required'  =>  false
            ])
        ;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch')
            ->remove('delete')
            ->remove('show')
            ->remove('export');
    }
}
