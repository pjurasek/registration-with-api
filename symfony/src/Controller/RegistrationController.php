<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Http\UserApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $roles = ['ROLE_USER'];
            if ($form->get('isAdministrator')->getData()) {
                $roles[] = 'ROLE_ADMINISTRATOR';
            }
            $user->setRoles($roles);

            $userApi = new UserApi(HttpClient::create());
            $userApi->storeInformation($user);

            return $this->redirectToRoute('app_show');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/all", name="app_show")
     * @return Response
     */
    public function show()
    {
        $userApi = new UserApi(HttpClient::create());
        $users = $userApi->fetchInformation();

        return $this->render(
            'registration/show.html.twig',
            ['users'=> $users]
        );
    }
}
