<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/04/2014
 * Time: 22:32
 */

namespace PhpDorset\Presentation;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PresentationController
 * @package PhpDorset\Presentation
 */
class PresentationController
{
    /**
     * @var PresentationRepository
     */
    protected $repository;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param PresentationRepository $eventRepository
     * @param Application $app
     */
    public function __construct(
        PresentationRepository $eventRepository,
        Application $app
    ) {
        $this->repository = $eventRepository;
        $this->app        = $app;
    }

    /**
     * @param $year
     * @param $month
     * @return JsonResponse
     */
    public function fetchCuesByYearAndMonth($year, $month)
    {
        $errors = [];

        $cues = array_map(
            function ($cue) {
                list($mins, $secs) = explode(':', $cue);
                return ($mins * 60) + ($secs);
            },
            $this->repository->fetchCues($year, $month)
        );

        if (!$cues) {
            $errors[] = 'Could not find any video cues for this talk';
        }

        $video_url = $this->repository->fetchVideo($year, $month);

        if (!empty($video_url)) {
            $errors[] = 'Could not find a video for this talk';
        }

        $pdfUrl = "/presentations/{$year}_{$month}.pdf";

        if (!file_exists(__DIR__ . '../../../web' . $pdfUrl)) {
            $errors[] = 'Could not find a presentation for this talk';
        }

        return $this->app['twig']->render(
            'talk.twig',
            array(
                'video_url' => $video_url,
                'pdf_url' => $pdfUrl,
                'cues' => $cues,
                'errors' => $errors
            )
        );
    }

    /**
     * @return JsonResponse
     */
    public function fetchAll()
    {
        $events = $this->repository->fetchAll();
        return new JsonResponse($events);
    }
}
