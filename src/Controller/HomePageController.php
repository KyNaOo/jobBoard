<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Postulate;
use App\Form\PostulateConnectedType;
use App\Form\PostulateType;
use App\Form\SearchTitleFormType;
use App\Repository\AdvertisementRepository;
use App\Repository\PostulateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;


class HomePageController extends AbstractController
{
    #[Route('/home', name: 'app_home_page')]
    public function index(AdvertisementRepository $advertisementRepository, Request $request): Response
    {
        $form = $this->createForm(SearchTitleFormType::class, null, [
            'action' => '/home'
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
            ]);
        }else{
            $ads = $advertisementRepository->getFiveLatestAd();
        }
        return $this->render('home_page/index.html.twig', [
            'form' => $form->createView(),
            'ads'=>$ads,
            'nbAds'=>$nbAds,
        ]);
    }   
    #[Route('/infos/{id}', name: 'app_infos')]
    public function searchTitle(EntityManagerInterface $entityManager, AdvertisementRepository $advertisementRepository, Advertisement $advertisement, Request $request, PostulateRepository $postulateRepository): Response
    {
        $postulate = new Postulate;
        $postulate->setAdvertisementId($advertisement);
        if($this->getUser()){
            $form = $this->createForm(PostulateConnectedType::class, null, [
            'action'=>$this->generateUrl('app_infos', ['id' => $advertisement->getId()]),
        ]);
        }else{
            $form = $this->createForm(PostulateType::class,$postulate,[
            'action'=>$this->generateUrl('app_infos', ['id' => $advertisement->getId()]),
        ]);
        }
        $date = new \DateTime();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            // $client = new Client([
            //     'base_uri' => 'http://127.0.0.1:8001/api/users',
            // ]);
            if ($this->getUser()){
                $postulate->setUserId($this->getUser())->setEmailSent($formData['emailSent']);
                // $response = $client->request('GET','http://127.0.0.1:8001/api/users?page=1');
                // $data = json_decode($response->getBody()->getContents());
                // dd($data->get('hydra:member'));
                $entityManager->persist($postulate);
                $entityManager->flush();
            }else{
                $entityManager->persist($postulate);
                $entityManager->flush();
            }
        }


        return $this->render('home_page/job.html.twig', [
            'form'=>$form->createView(),
            'ad'=>$advertisement,
            'user'=>$this->getUser(),
            'isConnected'=>!$this->getUser(),
        ]);
    }
    
}
