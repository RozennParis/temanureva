<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 16/08/18
 * Time: 17:33
 */

namespace App\Service;


class PaginationManager
{
    private $position;
    private $nbreElements;
    private $nbreElementsPerPage;
    private $nbreMaxPage;

    public function __construct(int $position, int $nbreElement, int $nbreElementPerPage, int $nbreMaxPage){
        $this->position = $position;
        $this->nbreElements = $nbreElement;
        $this->nbreElementsPerPage = $nbreElementPerPage;
        $this->nbreMaxPage = $nbreMaxPage;
    }

    public function getNbrePage(){
        $nbrePage = ceil($this->nbreElements / $this->nbreElementsPerPage);
        if($nbrePage > $this->nbreMaxPage){
            return $nbrePage;
        }
        return $nbrePage;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getNbreElements()
    {
        return $this->nbreElements;
    }

    /**
     * @param mixed $nbreElements
     */
    public function setNbreElements($nbreElements): void
    {
        $this->nbreElements = $nbreElements;
    }

    /**
     * @return mixed
     */
    public function getNbreElementsPerPage()
    {
        return $this->nbreElementsPerPage;
    }

    /**
     * @param mixed $nbreElementsPerPage
     */
    public function setNbreElementsPerPage($nbreElementsPerPage): void
    {
        $this->nbreElementsPerPage = $nbreElementsPerPage;
    }

    /**
     * @return mixed
     */
    public function getNbreMaxPage()
    {
        return $this->nbreMaxPage;
    }

    /**
     * @param mixed $nbreMaxPage
     */
    public function setNbreMaxPage($nbreMaxPage): void
    {
        $this->nbreMaxPage = $nbreMaxPage;
    }


}