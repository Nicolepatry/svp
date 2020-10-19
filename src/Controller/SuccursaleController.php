<?php

namespace App\Controller;
use App\Entity\Entite;
use App\Entity\Succursale;
use App\Repository\DepartementDesEntiteRepository;
use App\Repository\SuccursaleRepository;
use App\Repository\EntiteRepository;
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
use App\Form\SuccursaleType;

class SuccursaleController extends AbstractController
{
   
    /**
     * @Route("/succursale", name="app_succursale" ,methods="GET" )
     */
    public function index(SuccursaleRepository $succursaleRepository): Response
    {
        $succursales = $succursaleRepository->findAll();
        return $this->render('succursale/index.html.twig', compact('succursales'));
    }

    /**
     * @Route("/succursale/create/{id_entite}", name="app_succursale_create")
     */
    public function create(Request $request, EntityManagerInterface $em ,EntiteRepository $entiteRepository):Response
    {
        $id_entite = $request ->get('id_entite') ;

    	$formsuccursale = $this->createFormBuilder()
    		 ->add('libellelibelle', TextType::class, ['label' => 'Nom du Succusale'])
             ->add('nbre_employer', NumberType::class, ['label' => 'Nombre employer'])
             ->add('quartier', TextType::class, ['label' => 'Quartier'])
             ->add('arrondissement', TextType::class, ['label' => 'Arrondissement'])
             ->add('ville', TextType::class, ['label' => 'Ville'])
    		 ->getForm()
    	;

    	$formsuccursale->handleRequest($request);

    	if($formsuccursale->isSubmitted() && $formsuccursale->isValid()){

    			$data = $formsuccursale->getData();
    			$succursale =new Succursale;
    			$succursale ->setLibellelibelle($data['libellelibelle']);
    			$succursale ->setNbreEmployer($data['nbre_employer']);
    			$succursale ->setQuartier($data['quartier']);
    			$succursale ->setArrondissement($data['arrondissement']);
    			$succursale ->setVille($data['ville']);
    			$succursale ->setEntite($entiteRepository->findOneById($id_entite)); 
    			$em->persist($succursale);
    			$em->flush();

    			return $this->redirectToRoute('app_entite_show', array('id'=> $id_entite));
    	}
        
        return $this->render('succursale/create.html.twig',[
        	'succursaleformulaire'=> $formsuccursale ->createView()
        ]);
    }  


    /**
     * @Route("/succursale/edit/{id}", name="app_succursale_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SuccursaleRepository $succursaleRepository, Succursale $succursale): Response
    {

        $formsuccursale = $this->createForm(SuccursaleForm::class, $succursale);
        $formsuccursale->handleRequest($request);

        if ($formsuccursale->isSubmitted() && $formsuccursale->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_succursale');
        }

        return $this->render('succursale/edit.html.twig', [
            'succursale' => $succursale,
            'formsuccursale' => $formsuccursale->createView(),
        ]); 


    }


    /**
     * @Route("/succursale/show/{id}", name="app_succursale_show")
     */
    public function show(Request $request,SuccursaleRepository $succursaleRepository,DepartementDesEntiteRepository $depRepository, Succursale $succursale):Response
    {
        $id = $succursale ->getId();
        $nom = $succursale ->getLibellelibelle();
        $nbrempl = $succursale ->getNbreEmployer();
        $quartier = $succursale ->getQuartier();
        $arron = $succursale ->getArrondissement();
        $ville = $succursale ->getVille();
        $identit = $succursale ->getEntite(); 

        $departements = $this->departsuccursale($request, $depRepository, $id);
        
        return $this->render('succursale/show.html.twig', compact('id','nom','nbrempl','quartier','arron','ville','identit', 'departements' ));
    } 

    

    /**
     * @Route("succursale/delete/{id}", name="app_succursale_delete")
     */
    public function delete(Request $request, Succursale $succursale): Response
    {
        if ($this->isCsrfTokenValid('delete'.$succursale->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($succursale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_succursale');
    }

    
    public function departsuccursale(Request $request, DepartementDesEntiteRepository $depRepository, string $id_succursale): array
    {   
        $departements = $depRepository ->findBySuccursale($id_succursale);

        return $departements;
    }
}
