<?php

namespace AppBundle\Controller\Api;

use AppBundle\Service\AuthorizationServiceInterface;
use AppBundle\Service\InvitationServiceInterface;
use AppBundle\Transformer\InvitationTransformer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Invitation;

class InvitationController extends Controller
{
    /**
     * @var InvitationServiceInterface
     */
    private $invitationService;

    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    /**
     * InvitationController constructor.
     * @param InvitationServiceInterface $invitationService
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function __construct(InvitationServiceInterface $invitationService, AuthorizationServiceInterface $authorizationService)
    {
        $this->invitationService = $invitationService;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @Route("/api/v1/invitations", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function createInvitationAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        //Check user is authenticated
        if (null !== $user = $this->getUser()) {
            $invitation = new Invitation();
            $invitation->setUser($user);
            $invitation->setReceiverUsername($data['invitedUsername']);

            //Validating the request parameter
            $validator = $this->get('validator');
            $errors = $validator->validate($invitation);
            if (count($errors) > 0) {
                /// If validation got failed, return 400.
                $response = new JsonResponse((new InvitationTransformer())->transformErrors($errors), 400);
                return $response;
            }

            $id = $this->invitationService->createInvitation($invitation);
            $response = new JsonResponse((new InvitationTransformer())->transformCreate($id), 201);
            return $response;
        } else {
            /// If user is not authenticated return 401.
            $response = new JsonResponse([], 401);
            return $response;
        }
    }

    /**
     * @Route("/api/v1/invitations/sent", methods={"GET"})
     */
    public function GetSentInvitationsAction()
    {
        //Check user is authenticated
        if (null !== $user = $this->getUser()) {
            $res = $this->invitationService->listSentInvitations($user);
            $response = new JsonResponse($res, 200);
            return $response;
        } else {
            /// If user is not authenticated return 401.
            $response = new JsonResponse([], 401);
            return $response;
        }
    }

    /**
     * @Route("/api/v1/invitations/received", methods={"GET"})
     */
    public function GetReceivedInvitationsAction()
    {
        //Check user is authenticated
        if (null !== $user = $this->getUser()) {
            $res = $this->invitationService->listReceivedInvitations($user);
            $response = new JsonResponse($res, 200);
            return $response;
        } else {
            /// If user is not authenticated return 401.
            $response = new JsonResponse([], 401);
            return $response;
        }
    }

    /**
     * @Route("/api/v1/invitations/{id}/status/{status}", methods={"PUT"})
     * @param $id
     * @param $status
     * @return JsonResponse
     */
    public function AcceptRejectAnInvitationAction($id, $status)
    {
        //Check user is authenticated
        if (null !== $user = $this->getUser()) {
            //Authorization: only receiver of an invite can accept or reject an invitation
            $invitation = $this->authorizationService->canRespondToInvitation($user, $id);
            if ($invitation != NULL) {
                if (! in_array($status, [Invitation::STATUS_ACCEPTED, Invitation::STATUS_DECLINED])) {
                    $error = [$status . " is not a valid number for status."];
                    $response = new JsonResponse((new InvitationTransformer())->transformErrors($error), 400);
                } else {
                    $this->invitationService->changeInvitationStatus($invitation, $status);
                    $response = new JsonResponse([],200);
                }
            } else {
                //return 403 Exception in case of non-authorized requests
                $response = new JsonResponse([], 403);
            }
        } else {
            /// If user is not authenticated return 401.
            $response = new JsonResponse([], 401);
        }
        return $response;
    }

    /**
     * @Route("/api/v1/invitations/{id}", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function CancelAnInvitationAction($id)
    {
        //Check user is authenticated
        if (null !== $user = $this->getUser()) {
            //Authorization: only receiver of an invite can accept or reject an invitation
            $invitation = $this->authorizationService->canDeleteInvitation($user, $id);
            if ($invitation != NULL) {
                $this->invitationService->changeInvitationStatus($invitation,Invitation::STATUS_CANCELLED);
                $response = new JsonResponse([],200);
            } else {
                //return 403 Exception in case of non-authorized requests
                $response = new JsonResponse([],403);
            }
        } else {
            /// If user is not authenticated return 401.
            $response = new JsonResponse([], 401);
        }
        return $response;
    }
}