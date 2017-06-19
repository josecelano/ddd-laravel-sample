<?php

namespace App\Http\Controllers\Frontend\Appliance;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Appliance\ApplianceRepository;
use Mfa\Domain\ApplianceCategory;

class ApplianceController extends Controller
{
    /**
     * @var ApplianceRepository
     */
    private $applianceRepository;

    /**
     * ApplianceController constructor.
     * @param ApplianceRepository $applianceRepository
     */
    public function __construct(ApplianceRepository $applianceRepository)
    {
        $this->applianceRepository = $applianceRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dishwashers()
    {
        return view('frontend.appliance.list', [
            'appliances' => $this->applianceRepository->findByCategoryPaginate(ApplianceCategory::DISHWASHER)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smallAppliances()
    {
        return view('frontend.appliance.list', [
            'appliances' => $this->applianceRepository->findByCategoryPaginate(ApplianceCategory::SMALL_APPLIANCE)
        ]);
    }
}