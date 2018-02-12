<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Todo;
use AppBundle\Entity\FormId;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use PDO;
use Doctrine\DBAL\Driver\PDOException;



class DefaultController extends Controller
{

    /**
     * @Route("/todo/izpis", name="todo_izpis")
     */
    public function indexAction(Request $request)
    {
        $DBH = new PDO("mysql:host=127.0.0.1;dbname=todolist", 'root', '');
        $STH = $DBH->query('SELECT * from todo');

        $STH->setFetchMode(PDO::FETCH_ASSOC);

        $row = $STH->fetch();


        return $this->render('todo/izpis.html.twig', array(
            'row' => $row));


    }

    /**
     * @Route("/todo/izpis", name="todo_izpis")
     */

    public function isciAction()
    {

        $id="";
        $row = array();
        $post = Request::createFromGlobals();

        if ($post->request->has('submit')) {

            $id = $post->request->get('id');

            $query = array();
            $DBH = new PDO("mysql:host=127.0.0.1;dbname=todolist", 'root', '');


            $query = "SELECT * from todo WHERE id = :id";
            $STH = $DBH->prepare($query);
            $STH->execute(array(":id" => $id));

            $STH->setFetchMode(PDO::FETCH_ASSOC);

            $row = $STH->fetch();

         if (!$DBH) {
            throw $this->createNotFoundException();
            
         }   

        }

        return $this->render('todo/izpis.html.twig', array('id' => $id, 'row'=> $row));
    }


    public function apiNumberAction() {
        return new Response('Hello!');
    }





}



