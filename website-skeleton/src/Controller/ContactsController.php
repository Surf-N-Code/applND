<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactsController extends Controller
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function index()
    {
        return $this->render('contacts/index.html.twig', [
            'controller_name' => 'ContactsController',
        ]);
    }
}
