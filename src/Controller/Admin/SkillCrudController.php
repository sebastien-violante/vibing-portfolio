<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Compétence')
            ->setEntityLabelInPlural('Compétences')
            ->setDefaultSort(['category' => 'ASC', 'position' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield ChoiceField::new('category', 'Catégorie')->setChoices([
            'Frontend' => 'Frontend',
            'Backend' => 'Backend',
            'Outils' => 'Outils',
        ]);
        yield IntegerField::new('level', 'Niveau (1 à 5)')->setRequired(false);
        yield IntegerField::new('position', 'Position')
            ->setHelp('Plus le nombre est petit, plus la compétence apparaît tôt dans sa catégorie.');
    }
}