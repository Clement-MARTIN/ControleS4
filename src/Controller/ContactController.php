<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\NewContactType;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Permet editer une annonce
     *
     * @Route ("/contact/new", name="contact_new")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $contact = new Contact();
        $form = $this->createForm(NewContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'annonce <strong>{$contact->getId()}</strong> a bien été créer"
            );
            return $this->redirectToRoute('contact',
                [
                    'id' => $contact->getId()
                ]);
        }

        return $this->render('contact/new.html.twig',
            [
                'form' => $form->createView(),
                'var' => "Créer",
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(ContactRepository $repository): Response
    {
        $contacts =$repository->findAll();
        return $this->render('contact/index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("/article/{id}", name="contact_delete")
     *
     */
    public function delete($id, ObjectManager $manager, ContactRepository $repo)
    {
        $contact = $repo->findOneById($id);
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le contact a bien été supprimée"
        );

        return $this->redirectToRoute("contact");
    }

    /**
     * Permet afficher une annonce
     *
     * @Route ("/contact/{id}", name="contact_name")
     *
     * @return Response
     */
    public function show(Contact $contact)
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }

    /**
     * Permet afficher le form d'edition
     *
     * @Route("/contact/edit/{id}", name="contact_edit")
     *
     * @return Response
     */
    public function edit(Contact $contact, Request $request, ObjectManager $manager)
    {

        $form = $this->createForm(NewContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong>{$contact->getId()}</strong> a bien été modifié"
            );

            return $this->redirectToRoute('contact', [
                'id' => $contact->getId()
            ]);
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact,
            'var' => "Modifier",
        ]);
    }
}
