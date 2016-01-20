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
            ->add('Name')
            ->add('Title')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('Id')
            ->addIdentifier('Name', null, array(
                'label' => 'Alias',
                'sortable' => true,
            ))
            ->addIdentifier('Title', null, array(
                'label' => 'Название',
                'sortable' => true,
            ))
            ->add('Value', null, array(
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
        $formMapper
            ->add('Name', null, [
                'label' => 'Alias',
                'read_only' => !$this->getSubject()->isNew(),
            ])
            ->add('Title', null, [
                'label' => 'Название',
            ])
            ->add('Value', 'textarea', [
                'label' => 'Значение',
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
