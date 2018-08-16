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
    private $nbrElements;
    private $nbrElementsPerPage;
    private $nbrMaxPageDisplay;
    private $route;
    private $paramRoute;

    public function __construct(int $position, int $nbrElement, int $nbrElementPerPage, int $nbrMaxPage, string $route, array $paramRoute = []){
        $this->position = $position;
        $this->nbrElements = $nbrElement;
        $this->nbrElementsPerPage = $nbrElementPerPage;
        $this->nbrMaxPageDisplay = $nbrMaxPage;
        $this->route = $route;
        $this->paramRoute = $paramRoute;
    }

    /**
     * Retourne le nombre de page accésible
     * @return float
     */
    public function getNbrePage(){
        return ceil($this->nbrElements / $this->nbrElementsPerPage);
    }

    /**
     * Retoune le nombre de page à afficher
     * @return float|int
     */
    public function getNbrPageDisplay(){
        if($this->getNbrePage() < $this->nbrMaxPageDisplay){
            return $this->getNbrePage();
        }
        return $this->nbrMaxPageDisplay;
    }

    /**
     *
     * @return bool
     */
    public function isFirst(){
       return ($this->position == 1);
    }

    /**
     * @return bool
     */
    public function isLast(){
        return ($this->position == $this->getNbrePage());
    }

    public function getOffset(){
        $middle = ceil($this->nbrMaxPageDisplay/2);

        if($this->position <= $middle){
            return 1;
        }elseif ($this->position < $this->getNbrePage()-$middle){
            return ($this->position - $this->nbrMaxPageDisplay + $middle);
        }else{
            return ($this->getNbrePage() - $this->nbrMaxPageDisplay + 1);
        }
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
    public function getNbrElements()
    {
        return $this->nbrElements;
    }

    /**
     * @param mixed $nbrElements
     */
    public function setNbrElements($nbrElements): void
    {
        $this->nbrElements = $nbrElements;
    }

    /**
     * @return mixed
     */
    public function getNbrElementsPerPage()
    {
        return $this->nbrElementsPerPage;
    }

    /**
     * @param mixed $nbrElementsPerPage
     */
    public function setNbrElementsPerPage($nbrElementsPerPage): void
    {
        $this->nbrElementsPerPage = $nbrElementsPerPage;
    }

    /**
     * @return mixed
     */
    public function getNbrMaxPageDisplay()
    {
        return $this->nbrMaxPageDisplay;
    }

    /**
     * @param mixed $nbrMaxPageDisplay
     */
    public function setNbrMaxPageDisplay($nbrMaxPageDisplay): void
    {
        $this->nbrMaxPageDisplay = $nbrMaxPageDisplay;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getParamPagination(): string
    {
        return $this->paramPagination;
    }

    /**
     * @param string $paramPagination
     */
    public function setParamPagination(string $paramPagination): void
    {
        $this->paramPagination = $paramPagination;
    }

    /**
     * @return array
     */
    public function getParamRoute(): array
    {
        return $this->paramRoute;
    }

    /**
     * @param array $paramRoute
     */
    public function setParamRoute(array $paramRoute): void
    {
        $this->paramRoute = $paramRoute;
    }
}