<?php

namespace App\Controller;

use App\Form\SearchTitleFormType;
use App\Repository\AdvertisementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
            $ads = $advertisementRepository->getAdByTitle($formData['search']);
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
    // #[Route('/search', name: 'app_search_title')]
    // public function searchTitle(AdvertisementRepository $advertisementRepository, Request $request): Response
    // {
    //     $form = $this->createForm(SearchTitleFormType::class);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $formData = $form->getData();
    //         dd($formData);
    //         $ads = $advertisementRepository->getAdByTitle('test');
    //     }else{
    //         $ads = $advertisementRepository->getFiveLatestAd(); 
    //     }
    //     $nbAds = $advertisementRepository->getNbAd()[0]['1'];
    //     return $this->render('home_page/index.html.twig', [
    //         'form' => $form->createView(),
    //         'ads'=>$ads,
    //         'nbAds'=>$nbAds,
    //     ]);
    // }
    
}
