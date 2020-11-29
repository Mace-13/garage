<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
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

    /**
     * @Route("/showroom/new", name="new")
     * @param CarType $car
     * @return Response
     */
    public function create(){
        $car = new Car();

        $form = $this->createForm(CarType::class,$car);
        return $this->render('showroom/new.html.twig',[
            'myForm' => $form->createView()
        ]);

    }





}
