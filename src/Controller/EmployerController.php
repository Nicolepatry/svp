<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Repository\EmployerRepository;
use App\Repository\DepartementDesEntiteRepository;
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
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Entity\User;
use App\Form\UserType;

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
     * @Route("/upload-excel", name="xlsx")
     * @param Request $request
     * @throws \Exception
     */
   /* public function xslx(Request $request)
    {
        $file = $this->createFormBuilder()
            ->add('file',TextType::class, ['label' => 'selectionner le fichier excel  '])

            $role = self::getUser()->getRoles()[0];
             if(explode(" ", $role)[0] == 'ROLE_ADMIN'){
                        $file = $request->files->get('file'); // récupère le fichier de la requête envoyée
                       
                       $fileFolder = __DIR__ . '/../../public/uploads/';  // choisissez le dossier dans lequel le fichier téléchargé sera stocké
                      
                       $filePathName = md5(uniqid()) . $file->getClientOriginalName();
                          // appliquer la fonction md5 pour générer un identifiant unique pour le fichier et le concaténer avec l'extension de fichier 
                        try {
                            $file->move($fileFolder, $filePathName);
                        } catch (FileException $e) {
                            dd($e);
                }
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file 
        $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
    
     // dd($sheetData);
        $entityManager = $this->getDoctrine()->getManager(); 
        foreach ($sheetData as $Row) 
            { 

                $identifiant = $Row['A']; // stocker le identifiant à chaque itération
                $nom = $Row['B'];
                $prenom = $Row['C'];
                $email= $Row['D'];     
                $tel = $Row['E'];     
                $arrondissement = $Row['F'];
                $quartier= $Row['G'];     
                $ville = $Row['H'];
                $adresse = $Row['I'];
                $date_de_naissance = $Row['J'];
                $poste = $Row['K'];
                $postulant = $Row['L'];   

                $user_existant = $entityManager->getRepository(User::class)->findOneBy(array('email' => $email)); 
                    // controle l'utilisateur n'existe pas déjà dans votre base de données
                if (!$user_existant) 
                 {  

                    $employer =new Employer;
                    $employer ->setIdentifiant($identifiant);
                    $employer ->setNom($nom);
                    $employer ->setPrenom($prenom);
                    $employer ->setEmail($email);
                    $employer ->setTel($tel);
                    $employer ->setArrondissement($arrondissement);
                    $employer ->setQuartier($quartier); 
                    $employer ->setVille($ville);
                    $employer ->setAdresse($adresse);
                    $employer ->setDateDeNaissance($date_de_naissance); 
                    $employer ->setPoste($poste);
                    $employer ->setPostulant($postulant);

                    $entityManager->persist($employer);
                    $entityManager->flush(); 
                     // ici Doctrine vérifie tous les champs de toutes les données récupérées et effectue une transaction dans la base de données.
                 } 
            } 

             return $this->json('users registered', 200); 
             return $this->redirectToRoute('app_employer');

       }
        return $this->json('not Admin', 400);

    }  */  
                
    /**
     * @Route("/employer/create/{id_departement}", name="app_employer_create",methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em,DepartementDesEntiteRepository $departementdesentiteRepository ):Response
    {
        $id_departement = $request ->get('id_departement') ;

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
            ->add('postulant',TextType::class, ['label' => 'Postulant Election Syndical'])
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
                $employer ->setDepartementDesEntite($departementdesentiteRepository->findOneById($id_departement)); 
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
                    $identifiant =$employer ->getIdentifiant();
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
