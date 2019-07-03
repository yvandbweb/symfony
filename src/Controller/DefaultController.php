<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Compostuser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(Request $request)
    {
        $vararr=array();
        

        $repository = $this->getDoctrine()->getRepository(Post::class);
         
        $offset=0;
        $vararr["steps"]=4;
        $vararr["totalrest"]=ceil($repository->countposts()/$vararr["steps"]);    
        $vararr["i1"]=1;
        $vararr["total"]=$repository->countposts();            

        if ($request->query->get("i1")!=null){        
            $vararr["i1"]=$request->query->get("i1");
            $offset = ($vararr["i1"] - 1) * $vararr["steps"];             
        }
        
                                 
        $vararr["posts"] = $repository->findposts($offset,$vararr["steps"]);    
        
        
        
        return $this->render('default/index.html.twig',array("vararr"=>$vararr));
        
    }
    
    /**
     * @Route("/addcoment", name="addcomment")
     */
    public function addcoment(Request $request)
    {
        $vararr=array(); 
        $message="";
        

        //$repository = $this->getDoctrine()->getRepository(Post::class);
        $comment = new Comment();

         $form = $this->createFormBuilder($comment)
             ->add('text', TextareaType::class)
             ->add('user',
                    EntityType::class,
                    [
                        'class' => User::class,
                        'expanded' => false,
                        'multiple' => false
                    ]
                )
             ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {             
            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Post::class);                         
            $post = $repository->findOneBy(
                array('id'=>$request->request->get("id"))
            );            
            $comment->setPost($post);
            $comment->setDatetime(new \DateTime());
            /*
            $em->persist($comment);         
            $em->flush(); 
             * */
             
            
            return new JsonResponse(array('saved' => true,"html"=>$this->renderView('default/addcomment.html.twig', array(
                'text'=>$comment->getText(),'user'=>$comment->getUser(),'id'=>$comment->getId(),'datetime'=>$comment->getDatetime()
            )))); 
         }                 
         
         
        $vararr["id"]=$request->request->get("id");
        return $this->render('default/addcomment.html.twig',array('form' => $form->createView(),"vararr"=>$vararr));
        
    }    
    
    /**
     * @Route("/addpost", name="addpost")
     */
    public function addpost(Request $request)
    {
        $vararr=array();
        

        
        $request = $this->get('request_stack')->getMasterRequest();
        $post = new Post();

         $form = $this->createFormBuilder($post)
             ->setAction($this->generateUrl('addpost'))
             ->add('txt', TextareaType::class)
             ->add('user',
                    EntityType::class,
                    [
                        'class' => User::class,
                        'expanded' => false,
                        'multiple' => false
                    ]
                )
             ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $message="Saving posts hav been disabled";
            $test="yes";
            $em = $this->getDoctrine()->getManager();  
            $post->setDatetime(new \DateTime());

            //$em->persist($post);         
            //$em->flush();  

            //return $this->redirectToRoute('default');
         }                         
        $vararr["id"]=$request->request->get("id");
        $vararr["test"]="none";
        return $this->render('default/addpost.html.twig',array('form' => $form->createView(),"vararr"=>$vararr));
        
    }  
    
    /**
     * @Route("/adduser", name="adduser")
     */
    public function adduser(Request $request)
    {
        $vararr=array();        
        
        $request = $this->get('request_stack')->getMasterRequest();
        $user = new User();

         $form = $this->createFormBuilder($user)
             ->setAction($this->generateUrl('adduser'))
             ->add('nameuser', TextType::class)
             ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();  
            $user->setDatetime(new \DateTime());

            //$em->persist($user);         
            //$em->flush();  
            
            return $this->redirectToRoute('default');
         }     
         
        return $this->render('default/adduser.html.twig',array('form1' => $form->createView(),"vararr"=>$vararr));
        
    } 
    
 
    /**
     * @Route("/deletecomment", name="deletecomment")
     */
    public function deletecomment(Request $request)
    {
        
        $repository = $this->getDoctrine()->getRepository(Comment::class);                         
        $comment = $repository->findOneBy(
            array('id'=>$request->query->get("id"))
        );         

        $em = $this->getDoctrine()->getManager();  
        //$em->remove($comment);
      
        //$em->flush();  

        return $this->redirectToRoute('default');
        
    }   
        
    /**
     * @Route("/deletepost", name="deletepost")
     */
    public function deletepost(Request $request)
    {
        
        $repository = $this->getDoctrine()->getRepository(Post::class);                         
        $post = $repository->findOneBy(
            array('id'=>$request->query->get("id"))
        );         

        $em = $this->getDoctrine()->getManager();  
        //$em->remove($post);
      
        //$em->flush();  

        return $this->redirectToRoute('default');
        
    } 
    
        
    
}
