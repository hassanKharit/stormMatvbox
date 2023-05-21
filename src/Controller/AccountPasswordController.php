<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ChangePasswordType;

class AccountPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/changePw', name: 'app_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = NULL;
        $user = $this->getUser();
        $form = $this->createForm( ChangePasswordType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $user->setPassword($encoder->hashPassword($user,$new_pwd));
                // $doctrine = $this->getDoctrine()->getManager();
                if (!empty($this->entityManager)) {
                    $this->entityManager->flush();
                }
                $notification = "Votre mot de passe a bien été mise a jour";
            }else{
                $notification = "Votre mot de passe actuel n 'est pas correcte";

            }

        }
        return $this->render('account/password.html.twig', [
            "form" => $form->createView(),"notification" => $notification
        ]);
    }
}