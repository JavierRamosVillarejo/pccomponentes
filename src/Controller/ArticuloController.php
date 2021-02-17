<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articulo;
use App\Entity\Categoria;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class ArticuloController extends AbstractController {

    /**
     * @Route("/", name="inicio")
     */
    public function index(): Response {
        $repositorio = $this->getDoctrine()->getRepository(Articulo::class);
        $articulos = $repositorio->findAll();
        return $this->render('articulo/index.html.twig',
                        ['articulos' => $articulos]);
    }

    /**
     * @Route("/articulo/{id}", name="ver_articulo", requirements={"id"="\d+"})
     * @param int $id
     */
    public function ver(Articulo $articulo) {

        /* $repositorio = $this->getDoctrine()->getRepository(Articulo::class);
          $articulo = $repositorio->find($id);
         */

        return $this->render('articulo/ver_articulo.html.twig',
                        ['articulo' => $articulo]);
    }

    /**
     * @Route("/articulo/insertar", name="insertar_articulo")
     * @IsGranted("ROLE_USER") 
     */
    public function insertar(Request $request): Response {

        $articulo = new Articulo();
        $form = $this->createFormBuilder($articulo)
                ->add('nombre', TextType::class)
                ->add('descripcion', TextareaType::class)
                ->add('precio', MoneyType::class)
                ->add('categoria', EntityType::class, ['class' => Categoria::class,
                    'choice_label' => 'nombre'])
                ->add('foto', FileType::class, [
                    'label' => 'Selecciona foto',
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif'
                            ],
                            'mimeTypesMessage' => 'Formato de archivo no válido',
                                ])
                    ]
                ])
                ->add('enviar', SubmitType::class, ['label' => 'Insertar artículo'])
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articulo = $form->getData();

            $foto = $form->get('foto')->getData();
            
            if ($foto) {
                
                $nuevo_nombre = uniqid() . '.' . $foto->guessExtension();

                try {
                    $foto->move('imagenes/',$nuevo_nombre);
                    $articulo->setFoto($nuevo_nombre);
                } catch (FileException $e) {
                    
                }
            }


            //Guardamos el nuevo artículo en la base de datos
            $em = $this->getDoctrine()->getManager();
            $em->persist($articulo);
            $em->flush();

            return $this->redirectToRoute('inicio');
        }

        return $this->render('articulo/insertar_articulo.html.twig',
                        ['formulario' => $form->createView()]);





        return $this->redirectToRoute('inicio');
    }

    /**
     * @Route ("/articulo/borrar/{id}",name="borrar_articulo")
     * @return Response
     */
    public function borrar(Articulo $articulo): Response {
        $em = $this->getDoctrine()->getManager();
        $em->remove($articulo);
        $em->flush();
        return $this->redirectToRoute('inicio');
    }

}
