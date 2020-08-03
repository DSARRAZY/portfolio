<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\WebProfilerBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use App\Form\ContactType;
use App\Model\Contact;

class HomeController extends AbstractController
{
    /**
     * Home page display
     * @Route("/",name="home_index",methods={"GET","POST"})
     * @return Response A response instance
     */
    public function index(Request $request,ProjectRepository $project,MailerInterface $mailer) :Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from('hello@example.com')
                ->to('elbajaboxingacademytest@gmail.com')
                ->subject("Vous avez reçu un email d'un visiteur !")
                ->html($this->renderView('mail/mail.html.twig',[
                        'contact' => $contact
                ]));

            $mailer->send($email);

            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.');

        }

        return $this->render('index.html.twig', [
            'projects' => $project->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
