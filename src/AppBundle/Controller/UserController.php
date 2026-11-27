<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/users", name="user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);

        $keyword = trim($request->query->get('keyword', ''));

        if ($keyword !== '') {
            $users = $repository->searchUsers($keyword);
        } else {
            $users = $repository->findAllOrderedByLatest();
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'keyword' => $keyword
        ]);
    }

    /**
     * @Route("/users/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('password')->getData();

            if (empty($plainPassword)) {
                $this->addFlash('error', 'Password is required.');

                return $this->render('user/new.html.twig', [
                    'form' => $form->createView()
                ]);
            }

            $user->setPassword(
                $passwordEncoder->encodePassword($user, $plainPassword)
            );

            $user->setRoles($user->getRoles());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User created successfully.');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/{id}", name="user_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit", requirements={"id"="\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(
        Request $request,
        User $user,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('password')->getData();

            if (!empty($plainPassword)) {
                $user->setPassword(
                    $passwordEncoder->encodePassword($user, $plainPassword)
                );
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'User updated successfully.');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/users/{id}/deactivate", name="user_deactivate", requirements={"id"="\d+"})
     * @Method("POST")
     */
    public function deactivateAction(Request $request, User $user)
    {
        if (!$this->isCsrfTokenValid(
            'deactivate_user_' . $user->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $user->setIsActive(false);

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'User deactivated successfully.');

        return $this->redirectToRoute('user_index');
    }
}
