<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminCreateUserType;
use App\Form\ForUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/user')]
class UserController extends AbstractController
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $passHasher){
        $this->hasher = $passHasher;
    }

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(AdminCreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_RH']);
            $data = $form->getData();
            $user->setPassword($this->hasher->hashPassword($user, $data->getPassword()));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response

    {
        $id= $request->attributes->get('id');
        $userid=$this->getUser()->getId();
        if($id==$userid){
            $form = $this->createForm(ForUserType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $user->setPassword($this->hasher->hashPassword($user, $data->getPassword()));
                $entityManager->flush();
    
                return $this->redirectToRoute('app_home_page', [], Response::HTTP_SEE_OTHER);
            }
            return $this->render('user/edit.html.twig', [
                'userCo'=> 'ROLZ_USER',
                'user' => $user,
                'form' => $form,
            ]);
        } else if($this->getUser()->getRoles()[0]=='ROLE_ADMIN'){
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            $verif = false;
            if($user->getRoles()[0]=="ROLE_USER"){
                $verif = true;
            }
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
              return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            }
            return $this->render('user/edit.html.twig', [
                'userCo'=> $this->getUser()->getRoles()[0],
                'user' => $user,
                'form' => $form,
                'verif'=>$verif,
            ]);
        } else {
            throw new AccessDeniedException('Access denied');
        }
   
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

}
