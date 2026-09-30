<?php

namespace App\Controller\Admin;

use App\Entity\ProjectImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjectImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Champ d'envoi (formulaires uniquement)
        yield TextField::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions([
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
            ])
            ->onlyOnForms();

        // Aperçu dans les listes
        yield ImageField::new('filename', 'Aperçu')
            ->setBasePath('/uploads/projects')
            ->onlyOnIndex();

        yield TextField::new('caption', 'Légende')->setRequired(false);
        yield IntegerField::new('position', 'Ordre');
    }
}