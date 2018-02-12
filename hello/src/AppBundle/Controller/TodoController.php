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
use Symfony\Component\HttpFoundation\Response;


class TodoController extends Controller
{
    /**
     * @Route("/", name="todo_list")
     */
    public function listAction()
    {

        $todos = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->findAll();

        return $this->render('todo/index.html.twig', array (
            'todos' => $todos
            )

        );



    }

    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo;

        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))

             ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))

             ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))

             ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'LoW', 'Normal' => 'Normal', 'High' => 'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))

             
            ->add('save', SubmitType::class, array('label' => 'Create Todo','attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))

             ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //get data

            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');


            $todo ->setName($name);
            $todo ->setCategory($category);
            $todo ->setDescription($description);
            $todo ->setPriority($priority);
            $todo ->setDueDate($due_date);
            $todo ->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            $em ->persist($todo);
            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Added'
        );
            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);

        $now = new\DateTime('now');

        $todo->setName($todo->Getname());
        $todo->setCategory($todo->Getcategory());
        $todo->setDescription($todo->Getdescription());
        $todo->setPriority($todo->Getpriority());
        $todo->setDueDate($todo->GetdueDate());
        $todo->setCreateDate($now);




        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'LoW', 'Normal' => 'Normal', 'High' => 'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Edit Todo', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //get data

            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);


            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);


            $em->flush();

            $this->addFlash(
                'notice',
                'Todo updated!'
            );
            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/edit.html.twig', array(
            'todo' => $todo, 'form' =>  $form->createView()
        ));

    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->find($id);

        return $this->render('todo/details.html.twig', array(
            'todo' => $todo));

    }

    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     */

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);

        $em->remove($todo);
        $em->flush();

        $this->addFlash(
            'notice',
            'Todo removed!'
        );

        return $this->redirectToRoute('todo_list');

    }

    /**
     * @Route("/todo/testna", name="todo_testna")
     */


    public function testnaAction()
    {
        $conn = new PDO("mysql:host=127.0.0.1;dbname=todolist", 'root', '');
        $statement = $conn->prepare('SELECT * FROM todo');
        $statement->execute();
        $vsi = $statement->fetchAll();


        return $this->render('todo/testna.html.twig', array('vsi' => $vsi));

    }



}
