<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Repository\EmployerRepository;
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
use App\Form\EmployerType;


class EmployerController extends AbstractController
{
    /**
     * @Route("/employer", name="app_employer" ,methods="GET" )
     */
    public function index(EmployerRepository $employerRepository): Response
    {
        $employer = $employerRepository->findAll();
        return $this->render('employer/index.html.twig', compact('employer'));
    }


    /**
     * @Route("/employer/create", name="app_employer_create",methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em):Response
    {
    	$formemployer = $this->createFormBuilder()
            ->add('identifiant',TextType::class, ['label' => 'Matricule ou Numero de declaration  '])
    		->add('nom',TextType::class, ['label' => 'Nom '])
            ->add('prenom',TextType::class, ['label' => 'Prenom '])
            ->add('email',EmailType::class, ['label' => 'E-mail '])
            ->add('tel',TelType::class, ['label' => 'Telephone '])
            ->add('arrondissement',TextType::class, ['label' => 'Arrondissement '])
            ->add('quartier',TextType::class, ['label' => 'Quartier '])
            ->add('ville',TextType::class, ['label' => 'Ville '])
            ->add('adresse',TextType::class, ['label' => 'Adresse '])
            ->add('date_de_naissance',DateType::class, ['label' => 'Date de Naissance '])
            ->add('postulant',ChoiceType::class, ['label' => 'Postulant Election Syndical'])
    		 ->getForm()
    	;

    	$formemployer->handleRequest($request);

    	if($formemployer->isSubmitted() && $formemployer->isValid()){

    			$data = $formemployer->getData();
    			$employer =new Employer;
                $employer ->setIdentifiant($data['identifiant']);
    			$employer ->setNom($data['nom']);
    			$employer ->setPrenom($data['prenom']);
    			$employer ->setEmail($data['email']);
    			$employer ->setTel($data['tel']);
    			$employer ->setArrondissement($data['arrondissement']);
    			$employer ->setQuartier($data['quartier']); 
    			$employer ->setVille($data['ville']);
    			$employer ->setAdresse($data['adresse']);
    			$employer ->setDateDeNaissance($data['date_de_naissance']); 
    			$employer ->setPoste($data['poste']);
    			$employer ->setPostulant($data['postulant']);
    			$employer ->setDepartementDesEntite($data['departement_des_entite']); 
    			$em->persist($employer);
    			$em->flush();

    			return $this->redirectToRoute('app_employer');
    	}
        
        return $this->render('employer/create.html.twig',[
        	'employerformulaire'=> $formemployer ->createView()
        ]);
    }  


    /**
     * @Route("/employer/edit/{id}", name="app_employer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmployerRepository $employerRepository, Employer $employer): Response
    {

        $formemployer = $this->createForm(EmployerForm::class, $employer);
        $formemployer->handleRequest($request);

        if ($formemployer->isSubmitted() && $formemployer->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_employer');
        }

        return $this->render('employer/edit.html.twig', [
            'employer' => $employer,
            'formemployer' => $formemployer->createView(),
        ]); 


    }


    /**
     * @Route("/employer/show/{id}", name="app_employer_show")
     */
    public function show(EmployerRepository $employerRepository, Employer $employer):Response
    {
       $employer =new Employer;
                    $Midentifiant =$employer ->getIdentifiant();
                    $nom =$employer ->getNom();
                    $prenom =$employer ->getPrenom();
                    $mail =$employer ->getEmail();
                    $tel =$employer ->getTel();
                    $arrondi =$employer ->getArrondissement();
                    $quartier =$employer ->getQuartier(); 
                    $ville =$employer ->getVille();
                    $adress =$employer ->getAdresse();
                    $datnaiss =$employer ->getDateDeNaissance(); 
                    $post =$employer ->getPoste();
                    $postulant =$employer ->getPostulant();
                    $depentite =$employer ->getDepartementDesEntite(); 
        return $this->render('employer/show.html.twig', compact('nom','prenom','mail','tel','arrondi','quartier','ville','adress','datnaiss','post','postulant','depentite'));
    } 


    /**
     * @Route("employer/delete/{id}", name="app_employer_delete")
     */
    public function delete(Request $request, Employer $employer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_employer');
    }


}
