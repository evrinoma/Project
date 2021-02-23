<?php

namespace Evrinoma\ProjectBundle\Controller;


use Evrinoma\ProjectBundle\Manager\ProjectManager;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

/**
 * Class GridApiController
 *
 * @package Evrinoma\GridBundle\Controller
 */
final class ProjectApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var ProjectManager
     */
    private $projectManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param ProjectManager $projectManager
     */
    public function __construct($projectManager)
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(
                    new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()
                )
            )
            ->build();

        parent::__construct($serializer);
        $this->projectManager = $projectManager;
    }
//endregion Constructor

//region SECTION: Public

    /**
     * @Rest\Get("/api/project", options={"expose"=true}, name="api_project")
     * @OA\Get(tags={"project"})
     * @OA\Response(response=200,description="Returns projects")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function projectAction()
    {
        return $this->json($this->projectManager->setRestSuccessOk()->getAll(), $this->projectManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/project/column_defs", options={"expose"=true}, name="api_column_defs_project")
     * @OA\Get(tags={"project"})
     * @OA\Response(response=200,description="Returns column_defs project")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function projectColumnDefsAction()
    {
        return $this->json($this->projectManager->setRestSuccessOk()->getColumnDefs(), $this->projectManager->getRestStatus());
    }
}