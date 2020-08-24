<?php

namespace App\Controller;

use Symfony\Flex\Response;

use App\Entity\Commentaires;
use App\Entity\LivrablesPartiels;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;

use App\Repository\LivrableRenduRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response as HTTP_OK;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LivrablesPartielsController extends AbstractController
{

    /**
     * @Route("/livrables/partiels", name="livrables_partiels")
     */
    public function index()
    {
        return $this->render('livrables_partiels/index.html.twig', [
            'controller_name' => 'LivrablesPartielsController',
        ]);
    }
    
    /**
     * @Route(
     * name="postCommentairesLivrablesPartielsFormateur",
     * path="api/formateur/LivrablesPartiels/{idLiv}/commentaire",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\LivrablesPartielsController::postCommentairesLivrablesPartielsFormateur",
     * "_api_resource_class"=LivrablesPartiels::class,
     * "_api_collection_operation_name"="post_CommentairesLivrablesPartielsFormateur"
     * }
     * )
     */
    public function postCommentairesLivrablesPartielsFormateur(LivrableRenduRepository $LivRendu,Request $request,TokenStorageInterface $token ,SerializerInterface $serializer,$idLiv)
    {
        $userFormateur=$token->getToken()->getUser();
        $myCommentaire=json_decode($request->getContent(),true);
        $com = new Commentaires();
        $com->setFormateur($myCommentaire[$userFormateur]);
        $com->setLibelle($myCommentaire['libelle']);
        $com->getDate(new \DateTime());
        $pj = $request->files->get("pieceJointe");
        $pj= fopen($pj->getRealPath(),"rb");
        $com=setPieceJointe($pj);
        $com->setArchivage(1);
        $em= $this->getDoctrine()->getManager();
        $em->persist($com);
        $em->flush();
        fclose($pj);
    }

    /**
     * @Route(
     * name="postCommentairesLivrablesPartielsApprenant",
     * path="api/apprenant/LivrablesPartiels/{idLiv}/commentaire",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\Controller\LivrablesPartielsController::postCommentairesLivrablesPartielsApprenant",
     * "_api_resource_class"=LivrablesPartiels::class,
     * "_api_collection_operation_name"="post_CommentairesLivrablesPartielsApprenant"
     * }
     * )
     */

    public function postCommentairesLivrablesPartielsApprenant(LivrableRenduRepository $LivRendu,Request $request,TokenStorageInterface $token ,SerializerInterface $serializer,$idLiv)
    {
        $userFormateur=$token->getToken()->getUser();
        $myCommentaire=json_decode($request->getContent(),true);
        $com = new Commentaires();
        $com->setFormateur($myCommentaire[$userFormateur]);
        $com->setLibelle($myCommentaire['libelle']);
        $com->getDate(new \DateTime());
        $pj = $request->files->get("pieceJointe");
        $pj= fopen($pj->getRealPath(),"rb");
        $com=setPieceJointe($pj);
        $com->setArchivage(1);
        $em= $this->getDoctrine()->getManager();
        $em->persist($com);
        $em->flush();
        fclose($pj);
    }

    /**
     * @Route(
     * name="getCommentairesLivrablesPartiels",
     * path="api/formateur/LivrablesPartiels/{idLiv}/commentaire",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\LivrablesPartielsController::getCommentairesLivrablesPartiels",
     * "_api_resource_class"=LivrablesPartiels::class,
     * "_api_collection_operation_name"="get_CommentairesLivrablesPartiels"
     * }
     * )
     */
    public function getCommentairesLivrablesPartiels(LivrableRenduRepository $LivRendu,Request $request,TokenStorageInterface $token ,SerializerInterface $serializer,$idLiv)
    {
        $comment=$LivRendu->find($idLiv);
        $tableauComment=$comment->getCommentaires();
        $afficheCom =$serializer->serialize($tableauComment,"json");
        return new JsonResponse($afficheCom,HTTP_OK::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="getCompetencesByReferentielPromo",
     * path="api/formateur/promo/{idPro}/referentiel/{id}/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\LivrablesPartielsController::getCompetencesByReferentielPromo",
     * "_api_resource_class"=LivrablesPartiels::class,
     * "_api_collection_operation_name"="get_CompetencesByReferentielPromo"
     * }
     * )
     */
    public function getCompetencesByReferentielPromo(GroupeRepository $grp,PromoRepository $promRepo,SerializerInterface $serializer,$id,$idPro)
    {
        $promo=$promRepo->find($idPro);
        $tableauGrpeCompt=$promo->getReferentiel()->getGroupeCompetences();
        foreach($tableauGrpeCompt as $GrpeCompts){
            $tableauComp=$GrpeCompts->getCompetence()->getNiveau();

        $afficheComp =$serializer->serialize($tableauComp,"json");
        return new JsonResponse($afficheComp,HTTP_OK::HTTP_OK,[],true);
        }
        
    }

}