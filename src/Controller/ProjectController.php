<?php

namespace Evrinoma\ProjectBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GridController
 *
 * @package Evrinoma\GridBundle\Controller
 */
final class ProjectController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/project", options={"expose"=true}, name="project")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function project()
    {
        $event = ['titleHeader' => 'Project', 'pageName' => 'Project'];

        return $this->render('@EvrinomaProject/project.html.twig', $event);
    }

//endregion Public
}