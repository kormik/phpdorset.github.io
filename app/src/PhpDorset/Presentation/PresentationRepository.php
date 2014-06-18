<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/04/2014
 * Time: 23:01
 */

namespace PhpDorset\Presentation;

/**
 * Class PresentationRepository
 * @package PhpDorset\Presentation
 */
class PresentationRepository
{
    /**
     * @var array
     */
    protected $cues;

    /**
     * @param array $cues
     */
    public function __construct(array $cues)
    {
        $this->cues = $cues;
    }

    /**
     * @param string $year
     * @param string $month
     * @return array
     */
    public function fetchCues($year, $month)
    {
        return $this->cues[$year][$month]['cues'];
    }


    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchVideo($year, $month)
    {
        return $this->cues[$year][$month]['video'];
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->cues;
    }
}
