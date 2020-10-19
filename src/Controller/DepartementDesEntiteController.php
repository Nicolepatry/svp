<?php

namespace App\Controller;

use App\Entity\DepartementDesEntite;
use App\Repository\DepartementDesEntiteRepository;
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
use App\Form\DepartementDesEntiteType;


use App\Entity\Employer;
use App\Repository\EmployerRepository;
use App\Form\EmployerType;


class DepartementDesEntiteController extends AbstractController
{
   
    /**
     * @Route("/departementdesentite", name="app_departementdesentite" ,methods="GET" )
     */

    public function index(DepartementDesEntiteRepository $departementdesentiteRepository): Response
    {
        $departementdesentite = $departementdesentiteRepository->findAll();

        return $this->render('departement_des_entite/index.html.twig', compact('departementdesentite'));
    }

    /**
     * @Route("/departementdesentite/create/{id_succursale}", name="app_departementdesentite_create")
     */
    public function create(Request $request, SuccursaleRepository $succursaleRepository, EntityManagerInterface $em, DepartementDesEntiteRepository $departementdesentiteRepository):Response
    {
        $id_succursale = $request ->get('id_succursale') ;


    	$formdepartementdesentiteemployer = $this->createFormBuilder()
    		 ->add('libelle', TextType::class, ['label' => 'Nom du Succusale'])
    		 ->add('nbre_employer', NumberType::class, ['label' => 'Nombre employer'])

            
            ->add('nom',TextType::class, ['label' => 'Nom '])
            ->add('prenom',TextType::class, ['label' => 'Prenom '])
            ->add('email',EmailType::class, ['label' => 'E-mail '])
            ->add('tel',TelType::class, ['label' => 'Telephone '])
            ->add('arrondissement',TextType::class, ['label' => 'Arrondissement '])
            ->add('quartier',TextType::class, ['label' => 'Quartier '])
            ->add('ville',TextType::class, ['label' => 'Ville '])
            ->add('adresse',TextType::class, ['label' => 'Adresse '])
            ->add('date_de_naissance',DateType::class, ['label' => 'Date de Naissance '])
            ->add('postulant',TextType::class, ['label' => 'Postulant Election Syndical'])
            ->add('identifiant',TextType::class, ['label' => 'Matricule ou Numero de declaration  '])
            ->getForm()
        ;

    	$formdepartementdesentiteemployer->handleRequest($request);

    	if($formdepartementdesentiteemployer->isSubmitted() && $formdepartementdesentiteemployer->isValid()){

    			$data = $formdepartementdesentiteemployer->getData();
    			$departementdesentite =new DepartementDesEntite;
                $departementdesentite ->setChefdep(1);
    			$departementdesentite ->setLibelle($data['libelle']);
    			$departementdesentite ->setNbreEmployer($data['nbre_employer']);
    			$departementdesentite ->setsuccursale($succursaleRepository->findOneById($id_succursale));
                $em->persist($departementdesentite);
                $em->flush();
                $id_departement = $departementdesentite ->getId();
                $employer =new Employer;
                
                $employer ->setNom($data['nom']);
                $employer ->setPrenom($data['prenom']);
                $employer ->setEmail($data['email']);
                $employer ->setTel($data['tel']);
                $employer ->setArrondissement($data['arrondissement']);
                $employer ->setQuartier($data['quartier']); 
                $employer ->setVille($data['ville']);
                $employer ->setAdresse($data['adresse']);
                $employer ->setDateDeNaissance($data['date_de_naissance']); 
                $employer ->setPoste('Chef departement'.' '.$data['libelle']);
                $employer ->setPostulant($data['postulant']);
                $employer ->setIdentifiant($data['identifiant']);
                $employer ->setDepartementDesEntite($departementdesentiteRepository->findOneById($id_departement)); 
    			$em->persist($departementdesentite);
                $em->persist($employer);
    			$em->flush();

    			return $this->redirectToRoute('app_departementdesentite');
    	}
        
        return $this->render('departement_des_entite/create.html.twig',[
        	'departementdesentiteformulaire'=> $formdepartementdesentiteemployer ->createView()]);
    }  

    /**
     * @Route("/departementdesentite/edit/{id}", name="app_departementdesentite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DepartementDesEntiteRepository $departementdesentiteRepository, DepartementDesEntite $departementdesentite): Response
    {

        $formdepartementdesentite = $this->createForm(DepartementDesEntiteForm::class, $departementdesentite);
        $formdepartementdesentite->handleRequest($request);

        if ($formdepartementdesentite->isSubmitted() && $formdepartementdesentite->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_departementdesentite');
        }

        return $this->render('departementdesentite/edit.html.twig', [
            'departementdesentite' => $departementdesentite,
            'formdepartementdesentite' => $formdepartementdesentite->createView(),
        ]); 


    }


    /**
     * @Route("/departementdesentite/show/{id}", name="app_departementdesentite_show")
     */
    public function show(DepartementDesDntiteRepository $departementdesentiteRepository, Departementdesentite $departementdesentite):Response
    {
        $id = $departementdesentite ->getId();
        $chfdep  = $departementdesentite ->getNom();
        $succ = $departementdesentite ->getNumero();
        $employers = $this->employerdepartement($request, $employerRepository, $id);
        
        return $this->render('departementdesentite/show.html.twig', compact('id', 'chfdep', 'succ','employers '));
    } 


    /**
     * @Route("departementdesentite/delete/{id}", name="app_departementdesentite_delete")
     */
    public function delete(Request $request, DepartementDesEntite $departementdesentite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departementdesentite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($departementdesentite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_departementdesentite');
    }

    public function employerdepartement(Request $request, EmployerRepository $employerRepository, string $id_departement): array
    {
        
        $employers = $employerRepository ->findByEntite($id_departement);

        return $employers;
    }


      
   /* public function chefdep(Request $request): Response
    {
        $employer = new Employer;
        $form = $this->createForm(EmployerType::class, $employer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','chef enregistrer !');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employer);
            $entityManager->flush();

            return $this->redirectToRoute('app_departementdesentite_create');
        }

        return $this->render('departementdesentite/chefdep.html.twig', [
            'chefdep' => $employer,
            'form' => $form->createView(),
        ]);
    }*/


}
