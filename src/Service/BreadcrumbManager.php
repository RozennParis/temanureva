<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 18/08/18
 * Time: 11:52
 */

namespace App\Service;


class BreadcrumbManager
{
    private $breadcrumb;

    public function __construct()
    {
        $this->breadcrumb = array();
    }

    /**
     * @param string $route
     * @param string $name
     * @param array $parameters
     * @return BreadcrumbManager
     */
    public function add(string $route, string $name, array $parameters = []) : BreadcrumbManager
    {
        $this->breadcrumb[] = array(
            'route' => $route,
            'name' => $name,
            'parameters' => $parameters);

        return $this;
    }

    /**
     * @return array
     */
    public function getBreadcrumb(): array
    {
        return $this->breadcrumb;
    }

    /**
     * @param array $breadcrumb
     */
    public function setBreadcrumb(array $breadcrumb): void
    {
        $this->breadcrumb = $breadcrumb;
    }
}