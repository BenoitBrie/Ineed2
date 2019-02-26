<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Tightenco\Collect\Support\Collection;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('front/home.html.twig');
    }

    /**
     * @Route("/categorie/{slug}", name="front_categorie")
     * @param Categorie $categorie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categorie(Categorie $categorie)
    {
        $annonces = new Collection($categorie->getAnnonces());

        return $this->render('front/categorie.html.twig', [
           'annonces' => $annonces->sortByDesc(function ($col) {
               return $col->getDateCreation();
           }),
            'categorie'=>$categorie
        ]);
    }

}
