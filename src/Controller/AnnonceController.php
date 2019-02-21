<?php
/**
 * Created by PhpStorm.
 * User: Airone
 * Date: 20/02/2019
 * Time: 09:19
 */

namespace App\Controller;


use App\Entity\Annonce;
use App\Entity\Membre;
use App\Form\AnnonceFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AnnonceController extends AbstractController
{

    use HelperTrait;

    /**
     * @param Request $request
     * @return mixed
     * @Route("/creer-une-annonce", name="annonce_new")
     */
    public function newAnnonce(Request $request)
    {

        #creation nouvelle annonce
        $annonce = new Annonce();

        #auteur de l'annonce
        $annonce->setMembre($this->getUser());

        #creation formulaire
        $form = $this->createForm(AnnonceFormType::class, $annonce);

        #traitement du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            #upload de l'image
            $featuredImage = $annonce->getFeaturedImage();

            #renommer le nom de fichier
            $fileName = $this->slugify($annonce->getTitre())
                . '.' . $featuredImage->guessExtension();

            #deplacer vers repertoire final
            $featuredImage->move(
                $this->getParameter('annonce_assets_dir'),
                $fileName
            );

            #mise a jour Image
            $annonce->setFeaturedImage($fileName);

            #mise a jour slug
            $annonce->setSlug($this->slugify($annonce->getTitre()));

            #sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            #redirection
            #return $this->redirectToRoute('', [
            #    'categorie' => $annonce->getCategorie()->getSlug(),
            #    'slug' => $annonce->getSlug(),
            #    'id' => $annonce->getId()
            #]);
        }

        #passage a la vue
        return $this->render('annonce/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAnnonce($id, Request $request)
    {
        #recup de l'annonce en BDD
        $annonce = $this->getDoctrine()
            ->getRepository(Annonce::class)
            ->find($id);

        #recup de l'Image
        $featuredImage = $annonce->getFeaturedImage();

        #creation du formulaire
        $annonce->setFeaturedImage(
            new File($this->getParameter('annonce_assets_dir')
                . '/' . $annonce->getFeaturedImage())
        );

        $form = $this->createForm(AnnonceFormType::class, $annonce)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if ($annonce->getFeaturedImage() != null) {

                #upload image
                /**
                 * @var UploadedFile $featuredImage
                 */
                $featuredImage = $annonce->getFeaturedImage();

                #renommer le fichier
                $fileName = $this->slugify($annonce->getTitre())
                    . '.' . $featuredImage->guessExtension();

                #deplacer vers repertoire final
                $featuredImage->move(
                    $this->getParameter('annonce_assets_dir'),
                    $fileName
                );

                #mise a jour image
                $annonce->setFeaturedImage($fileName);
            }
            else {
                $annonce->setFeaturedImage($featuredImage);
            }

            #mise a jour slug
            $annonce->setSlug($this->slugify($annonce->getTitre()));

            #sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            #redirection
            return $this->redirectToRoute('/{categorie<[a-zA-z0-9\-_\/]+>}/{slug<[a-zA-z0-9\-_\/]+>}_{id<\d+>}.html', [
                'categorie' => $annonce->getCategorie()->getSlug(),
                'slug' => $annonce->getSlug(),
                'id' => $annonce->getId()
            ]);

        }

        return $this->render('annonce/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
