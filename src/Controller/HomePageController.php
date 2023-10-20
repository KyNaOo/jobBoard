<?php
namespace App\Controller;
use App\Entity\Postulate;
use App\Form\AdvertisementType;
use App\Form\SearchTitleFormType;
use App\Repository\AdvertisementRepository;
use App\Repository\CompanyRepository;
use App\Repository\PostulateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(EntityManagerInterface $entityManager, AdvertisementRepository $advertisementRepository, Request $request, PostulateRepository $postulateRepository): Response
    {
        $postulate = new Postulate;
        if($this->getUser()){
            $role = $this->getUser()->getRoles()[0];
            $user=$this->getUser();
        } else {
            $role = null;
            $user=null;
        }
        $form = $this->createForm(SearchTitleFormType::class, null, [
            'action' => '/'
        ]);
        $form->handleRequest($request);
        $nbAds = $advertisementRepository->getNbAd()[0]['1'];
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            if ($formData['search']){
                $ads = $advertisementRepository->getAdByTitle($formData['search']);
            } else {
                $ads = [];
            }
            return $this->render('home_page/index.html.twig', [
                'form' => $form->createView(),
                'ads'=>$ads,
                'nbAds'=>$nbAds,
                'role'=>$role,
                'user'=>$user,
            ]);
        }else{
            $ads = $advertisementRepository->getFiveLatestAd();
        }
        if($_POST){
            $verif =true;
            $l=[];
             $postulate
            ->setEmailSent($_POST['emailSent'])
            ->setAdvertisementId($advertisementRepository->getAdById($_POST['adId'])[0]); 
            if($this->getUser()){
                $postulate->setUserId($this->getUser());
                $thePos = $postulateRepository->getPosByUser($this->getUser()->getId());
                    foreach($thePos as $thePo){
                        if($thePo->getAdvertisementId()->getId()==intval($_POST['adId'])){
                            $verif=false;
                        }
                    }
            } else {
                $postulate
                ->setUserName($_POST['firstName'])
                ->setUserLastName($_POST['lastName'])
                ->setUserEmail($_POST['email'])
                ->setUserTel($_POST['tel']);
            }
            if($verif){
                $entityManager->persist($postulate);
                $entityManager->flush();
            }
        }
        return $this->render('home_page/index.html.twig', [
            'form' => $form->createView(),
            'ads'=>$ads,
            'nbAds'=>$nbAds,
            'role'=>$role,
            'user'=>$user,
        ]);
    }

    #[Route('/post', name: 'app_post_job')]
    public function postJob(CompanyRepository $companyRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdvertisementType::class, null, [
            'action' => '/post'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime;
            $formData = $form->getData();
            $company = $companyRepository->getCompById($this->getUser()->getCompanyId()->getId())[0];
            $formData->setCompanyId($company)->setUserId($this->getUser())->setDatePub($date);
            $entityManager->persist($formData);
            $entityManager->flush();
            return $this->redirectToRoute('app_home_page', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('home_page/postJob.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}