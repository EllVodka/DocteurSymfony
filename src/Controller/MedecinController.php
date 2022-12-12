<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Form\MedecinType;
use App\Repository\DocteurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin")
     */
    public function index(DocteurRepository $docteurRepository): Response
    {
        $docteurs = $docteurRepository->findAll();
        return $this->render('medecin/index.html.twig', [
            'docteurs' => $docteurs
        ]);
    }

    /**
     * @Route("/medecin/{id<\d+>}", name="medecin_view")
     */
    public function view(int $id,DocteurRepository $docteurRepository): Response
    {
        $docteur = $docteurRepository->find($id);
        return $this->render('medecin/view.html.twig', [
            'docteur'=>$docteur
            
        ]);
    }

    /**
     * @Route("/medecinAdd", name="medecin_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $docteur= new Docteur();
        $form = $this->createForm(MedecinType::class,$docteur);

        $manager = $doctrine->getManager();  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $docteur->setNom("Dr. " . $docteur->getNom());
            $docteur = $form->getData();
            $manager->persist($docteur);
            $manager->flush();
            dump($docteur);
            return $this->redirectToRoute('medecin_view',array("id"=> $docteur->getId()));
        }

        return $this->renderForm('medecin/add.html.twig',[
            'form'=> $form
        ]);
    }


}
