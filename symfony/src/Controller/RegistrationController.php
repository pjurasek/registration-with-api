<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Http\UserApi;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

            $this->addFlash(
                'notice',
                'You registered a new user!'
            );

            return $this->redirectToRoute('app_show');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/all", name="app_show")
     * @param LoggerInterface $logger
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function show(LoggerInterface $logger)
    {
        $userApi = new UserApi(HttpClient::create());

        try {
            $users = $userApi->fetchInformation();
        } catch (\Exception $exception) {
            $logger->error($exception->getMessage());
        }

        if (!$users) {
            throw new NotFoundHttpException('The user does not exists.');
        }

        return $this->render(
            'registration/show.html.twig',
            ['users'=> $users]
        );
    }
}
