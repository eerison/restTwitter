<?php

namespace restTwitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Twitter controller.
 *
 * @Route("/twitter")
 */
class TwitterController extends Controller
{
    /**
     * Lists all Twitter entities.
     *
     * @Route(".{_format}", requirements={"_format" : "html|json|xml"}, name="twitter_index")
     * @Method("GET")
     */
    public function indexAction($_format)
    {
        $em = $this->getDoctrine()->getManager();
        $twitters = $em->getRepository('restTwitterBundle:Twitter')->findPost(10);

        if($_format == 'html')
            return $this->render('restTwitterBundle:twitter:index.html.twig', array(
                'twitters' => $twitters,
            ));

        $serializer = $this->container->get('jms_serializer');
        $data = $serializer->serialize($twitters, $_format);
        return new Response($data);


    }

    /**
     * Lists all Twitter entities.
     *
     * @Route("/add.{_format}", requirements={"_format" : "html|json|xml"}, name="twitter_add")
     * @Method("POST")
     */
    public function addAction(Request $request, $_format)
    {

        $params = $request->getContent();

        $serializer = $this->container->get('jms_serializer');
        $object = $serializer->deserialize($params, 'restTwitterBundle\Entity\Twitter', 'json');
        $object->setDate(new \DateTime('now'));

        $object->setName( $this->nameToText($object) );
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();

        $data = $serializer->serialize($params, $_format);

        return new Response($data);
    }

    private function nameToText(\restTwitterBundle\Entity\Twitter $object)
    {
        $matches = array();
        $name    = null;

        /**
         * tem que iniciar com @
         * o conteudo que vai ser extraido nao pode conter @ nem espaço
         * no final tem que ter um espaço para pegar o nome
         */
        preg_match('/^@[^@|^ (.*)]+ /', $object->getText(), $matches);

        //caso tenha nome
        if(!empty($matches[0])){
            //pega o primeiro elemento da matriz
            list($name) = $matches;
            //retira o nome do usuario do texto
            $object->setText(str_replace($name, '', $object->getText()));
            // retirar o @ eo ultimo epaço.
            $name       = substr($name,1,-1);
        }

        return $name;
    }

}
