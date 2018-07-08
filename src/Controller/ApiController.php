<?php

namespace App\Controller;

use App\Entity\LinkRequestStats;
use App\Entity\ShortLink;
use App\Services\ShortLink\Shorter;
use App\Services\ShortLink\WrongUrlShorterException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    private $shorter;

    public function __construct(Shorter $shorter)
    {
        $this->shorter = $shorter;
    }

    /**
     * @Route("/shortlink/{url}")
     */
    public function shortLinkRequested(Request $request, $url)
    {
        try {
            $id = $this->shorter->getShorterId($url);
        } catch (WrongUrlShorterException $ex) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }

        $shortLink = $this->getDoctrine()->getRepository('App:ShortLink')->find($id);

        if ($shortLink) {
            $this->saveLinkRequestStats($request, $shortLink);

            return new JsonResponse([
                'url' => $shortLink->getUrl(),
            ]);
        }

        return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
    }

    private function saveLinkRequestStats(Request $request, ShortLink $shortLink) {
        $ip = $request->request->get('ip', '');
        $device = $request->request->get('device', LinkRequestStats::UNKNOWN_DEVICE);

        $stats = new LinkRequestStats();
        $stats->setShortLink($shortLink);
        $stats->setCreatedAt(new \DateTime());
        $stats->setIp($ip);
        $stats->setDevice($device);

        $em = $this->getDoctrine()->getManager();
        $em->persist($stats);
        $em->flush();
    }
}