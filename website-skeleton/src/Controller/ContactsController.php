<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactsController extends Controller
{

    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @Route("/Kontakt", name="contact_form")
     */
    public function login(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        $errors = array();
        $contacts = new Contacts();

        if($form->isSubmitted()) {
            $formData = $form->getData();

            //Validate form constraints
            $err = $form->getErrors(true);
            foreach ($err as $index => $e) {
                $errors[]['message'] = $e->getMessage();
            }

            if(count($errors) > 0 ) {
                return $this->render("contacts.html.twig", [
                    'our_form' => $form->createView(),
                    'errors' => $errors
                ]);
            }

            if(count($errors) == 0 && $form->isValid()) {
                //Save contact details to db
                $em = $this->getDoctrine()->getManager();

                $em->persist($formData);
                $em->flush();
            }
        }

        return $this->render("contacts.html.twig", [
            'our_form' => $form->createView(),
            'errors' => $errors,
        ]);
    }
}
