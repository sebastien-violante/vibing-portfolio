<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use App\Repository\ProfileRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileCrudController extends AbstractCrudController
{
    public function __construct(private ProfileRepository $profiles) {}

    public static function getEntityFqcn(): string
    {
        return Profile::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Profil')
            ->setEntityLabelInPlural('Profil');
    }

    public function configureActions(Actions $actions): Actions
    {
        // Une seule ligne de profil : pas de suppression, et pas de création si elle existe déjà
        $actions->disable(Action::DELETE);
        if ($this->profiles->count([]) > 0) {
            $actions->disable(Action::NEW);
        }
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('fullName', 'Nom complet');
        yield TextField::new('jobTitle', 'Intitulé du poste');
        yield TextareaField::new('bio', 'À propos')->hideOnIndex();
        yield EmailField::new('email', 'Email');
        yield UrlField::new('githubUrl', 'GitHub')->hideOnIndex();
        yield UrlField::new('linkedinUrl', 'LinkedIn')->hideOnIndex();

        yield TextField::new('photoFile', 'Photo')
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions(['required' => false, 'allow_delete' => false, 'download_uri' => false, 'image_uri' => true])
            ->onlyOnForms();
        yield ImageField::new('photoFilename', 'Photo')
            ->setBasePath('/uploads/profile')
            ->onlyOnIndex();

        yield TextField::new('cvFile', 'CV (PDF)')
            ->setFormType(VichFileType::class)
            ->setFormTypeOptions(['required' => false, 'allow_delete' => false, 'download_uri' => false])
            ->onlyOnForms();
    }
}