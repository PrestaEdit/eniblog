<?php

namespace Eni\Blog\Services;

use PrestaShop\PrestaShop\Core\Kpi\Row\KpiRowInterface;

class KPIPresenterService {
    private $decoratedService;

    /**
     * @param DecoratedService $decoratedService
     */
    public function __construct($decoratedService)
    {
        $this->decoratedService = $decoratedService;
    }

    public function present(KpiRowInterface $kpiRow)
    {
        return $this->decoratedService->present($kpiRow);
    }
}