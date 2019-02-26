<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Membre;
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

    /**
     * @Route("/mes-annonces.html", name="mes_annonces")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mesannonces()
    {
        /** @var Membre $membre */
        $membre = $this->getUser();
        $annonces = new Collection($membre->getAnnonces());

        $categorie = new Categorie();
        $categorie->setNom('Mes Annonces');

        return $this->render('front/categorie.html.twig', [
            'annonces' => $annonces->sortByDesc(function ($col) {
                return $col->getDateCreation();
            }),
            'categorie' => $categorie
        ]);
    }

}
