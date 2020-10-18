<?php

namespace App\Controller;
use App\Entity\Entite;
use App\Repository\EntiteRepository;
use App\Repository\SuccursaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\EntiteType;
use App\Form\EntiteForm;


class EntiteController extends AbstractController
{
    /**
     * @Route("/entite", name="app_entite" ,methods="GET" )
     */
    public function index(EntiteRepository $entiteRepository): Response
    {
        $entites = $entiteRepository->findAll();
        return $this->render('entite/index.html.twig', compact('entites'));
    }


    /**
     * @Route("/entite/create", name="app_entite_create",methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em):Response
    {
    	$formentite = $this->createFormBuilder()
    		->add('nom',TextType::class, ['label' => 'Nom Entite'])
            ->add('numero',TextType::class, ['label' => 'Numero RCM ou Numero Enregistrement'])
            ->add('nbre_succursale',TextType::class, ['label' => 'Nombre de Succursale'])
            ->add('etat_entite',TextType::class, ['label' => 'Type Entreprise'])
            ->add('raison_sociale',TextType::class, ['label' => 'Raison Sociale'])
            ->add('siege',NumberType::class, ['label' => 'Siege'])
    		->getForm()
    	;

    	$formentite->handleRequest($request);

    	if($formentite->isSubmitted() && $formentite->isValid()){

    			$data = $formentite->getData();
    			$entite =new Entite;
    			$entite ->setNom($data['nom']);
    			$entite ->setNumero($data['numero']);
    			$entite ->setNbreSuccursale($data['nbre_succursale']);
    			$entite ->setEtatEntite($data['etat_entite']);
    			$entite ->setRaisonSociale($data['raison_sociale']);
    			$entite ->setSiege($data['siege']); 
    			$em->persist($entite);
    			$em->flush();

    			return $this->redirectToRoute('app_entite');
    	}
        
        return $this->render('entite/create.html.twig',[
        	'entiteformulaire'=> $formentite ->createView()
        ]);
    }  

    /**
     * @Route("/entite/edit/{id}", name="app_entite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EntiteRepository $entiteRepository, Entite $entite): Response
    {

        $formentite = $this->createForm(EntiteForm::class, $entite);
        $formentite->handleRequest($request);

        if ($formentite->isSubmitted() && $formentite->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_entite');
        }

        return $this->render('entite/edit.html.twig', [
            'entite' => $entite,
            'formentite' => $formentite->createView(),
        ]); 


    }


    /**
     * @Route("/entite/show/{id}", name="app_entite_show")
     */
    public function show(Request $request, EntiteRepository $entiteRepository, Entite $entite, SuccursaleRepository $succursaleRepository):Response
    {
        $id = $entite ->getId();
        $nom = $entite ->getNom();
        $numero = $entite ->getNumero();
        $nbsucc = $entite ->getNbreSuccursale();
        $etatentite = $entite ->getEtatEntite();
        $rsoc = $entite ->getRaisonSociale();
        $siege = $entite ->getSiege();

        $succursales = $this->entitesuccursale($request, $succursaleRepository, $id);

        return $this->render('entite/show.html.twig', compact('id', 'nom', 'numero','nbsucc','etatentite', 'rsoc', 'siege',     'succursales'));
    } 


    /**
     * @Route("entite/delete/{id}", name="app_entite_delete")
     */
    public function delete(Request $request, Entite $entite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entite');
    }

    public function entitesuccursale(Request $request, SuccursaleRepository $succursaleRepository, string $id_entite): array
    {
        //$id_entite = $_GET['id'];
        //$id_entite = $request -> query ->get ('id') ;
        
        $succursales = $succursaleRepository ->findByEntite($id_entite);

        return $succursales;
    }
}
