<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet')
            ->setEntityLabelInPlural('Projets')
            ->setDefaultSort(['position' => 'ASC', 'projectDate' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Titre');
        yield SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex();
        yield TextField::new('shortDescription', 'Description courte')->hideOnIndex();
        yield TextareaField::new('description', 'Description détaillée')->hideOnIndex();
        yield ArrayField::new('stack', 'Technologies')->hideOnIndex();
        yield UrlField::new('githubUrl', 'Lien GitHub')->hideOnIndex();
        yield UrlField::new('demoUrl', 'Lien démo')->hideOnIndex();
        yield DateField::new('projectDate', 'Date');
        yield IntegerField::new('position', 'Position');
        yield BooleanField::new('isPublished', 'Publié');
        yield CollectionField::new('images', 'Images')
            ->useEntryCrudForm(ProjectImageCrudController::class)
            ->hideOnIndex();
    }
}