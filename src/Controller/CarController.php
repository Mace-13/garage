<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Image;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @param CarRepository $repo
     * @Route("/showroom/", name="showroom")
     * @return Response
     */
    public function showroom(CarRepository $repo)
    {
        $cars = $repo->findAll();
        return $this->render('showroom/index.html.twig',[
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/showroom/new", name="new")
     * @param CarType $car
     * @return Response
     */
    public function create(EntityManagerInterface $manager, Request $request){
        $car = new Car();

        $form = $this->createForm(CarType::class,$car);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){

            foreach($car->getImages() as $image){
                $image->setCar($car);
                $manager->persist($image);
            }

            $manager->persist($car);
            $manager->flush();

            $this->addFlash(
                'success',
                "la voiture <strong>{$car->getMarque()}</strong> a bien été enregistrée"
            );

            return $this->redirectToRoute('show',[
                'slug' => $car->getSlug()
            ]);

        }
        return $this->render('showroom/new.html.twig',[
            'myForm' => $form->createView()
        ]);

    }

    /**
     * Permet d'afficher une seule voiture
     * @Route("/showroom/{slug}", name="show")
     *
     * @param [string] $slug
     * @return Response
     */
    public function show(Car $car)
    {

        return $this->render('showroom/show.html.twig',[
            'car' => $car
        ]);
    }







}
