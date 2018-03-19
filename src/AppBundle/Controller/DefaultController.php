<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Url;
use AppBundle\Entity\Description;
use AppBundle\Form\FirstType;
use AppBundle\Form\ModifType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('base.html.twig');
    }
    
    
    public function formAction(Request $request)
    {
        $url = new Url();
        $form = $this->get('form.factory')->create(FirstType::class, $url);
        
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            
            
            if ($form->isValid()) {
                
                $url = $form->getData();
                $session = $request->getSession();
                $session->set('url', $url);
                
                return $this->redirectToRoute('title');
            }
        }
        return $this->render('base.html.twig', array(
            'form' => $form->createView(),
            'base_dir' => $this->get('kernel')->getRootDir() . '/../web' . $request->getBasePath()
        ));
    }
    
    
    public function titleAction(Request $request)
    {

        $session = $request->getSession();
        $url = $session->get('url');
        
        
        
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $data= curl_exec($ch);
        curl_close($ch);

      

        // print title
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
        
        // print h1
        $h1= preg_match('/<h1[^>]*>(.*?)<\/h1>/ims', $data, $matches) ? $matches[1] : null;
        
        
        //print description
        $count = preg_match_all('/\<meta.name="(\w*)".content="(.*)"/i', $data, $matches); // get all the meta tags with name and content
        
        if (stripos(strtolower($data),$data) !== false) {
        // 'see details' is in the $line
          }
        foreach ($matches[1] as $key => $value){
            if ($value == 'description'){
                $description_key =  $key;
            }
        }
        if(isset($description_key))
           $tags = $matches[2][$description_key];
        /* else
         
          $count = preg_match_all('/\<meta.name="(\w*)".content="(.*)"/i', strtolower($data), $matches); // get all the meta tags with name and content
       
        foreach ($matches[1] as $key => $value){
            if ($value == 'description'){
                $description_key =  $key;
            }
        }
        if(isset($description_key))
           $tags = $matches[2][$description_key]; 

                  */
        
        //print img
        
        $img = preg_match('/(https?:\/\/.*\.(?:png|jpg))/i', $data, $matches) ? $matches[1] : null;
        $alts = preg_match_all('/<img.*?alt="(.*?)"[^\>]+>/i', $data, $matches) ? $matches[1] : null;
        
        // create a new form
        $description = new Description();
        $form = $this->get('form.factory')->create(ModifType::class, $description);
        
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                
                $description = $form->getData();
                $session = $request->getSession();
                $session->set('description', $description);
                $session = $request->getSession();
                $description = $session->get('description');
                
                $tags= $description->getDescription();
                $title= $description->getTitle();
                $url= $description->getUrl();
           
            }
            
        }
        $session = $request->getSession();
        $session->set('url', $url);
        $session->set('tags', $tags);
        $session->set('title', $title);

        return $this->render('result.html.twig', array(
            'url' => $url,
            'title' => $title,
            'h1' => $h1,
            'tags' => $tags,
            'alts' => $alts,
            'form' => $form->createView(),
            'base_dir' => $this->get('kernel')->getRootDir() . '/../web' . $request->getBasePath()
        ));
        
      
    }
    

}