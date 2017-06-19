<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Services\Wishlist\WishlistService;
use Illuminate\Http\Request;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use Mfa\Application\Command\AddApplianceToWishlistCommand;
use Mfa\Application\Command\RemoveApplianceFromWishlistCommand;
use Mfa\Domain\WishlistRepository;

class WishlistController extends Controller
{
    use DispatchesCommands;

    /**
     * @var WishlistService
     */
    private $wishlistService;

    /**
     * @var WishlistRepository
     */
    private $wishlistRepository;

    /**
     * WishlistController constructor.
     * @param WishlistService $wishlistService
     * @param WishlistRepository $wishlistRepository
     */
    public function __construct(WishlistService $wishlistService, WishlistRepository $wishlistRepository)
    {
        $this->wishlistService = $wishlistService;
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($userId)
    {
        $this->wishlistService->makeSureTheUserHasAWishlist($userId);
        $wishlistReadModel = $this->wishlistService->findUserWishlist($userId);

        return view('frontend.wishlist.list', [
            'wishlist' => $wishlistReadModel,
            'wishlistOwner' => $wishlistReadModel->user,
            'appliances' => $wishlistReadModel->appliances()->paginate(),
        ]);
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAppliance(Request $request, $userId)
    {
        if ($userId != access()->id()) {
            abort(403, 'You can only add appliances to your own wishlist');
        }

        $applianceId = $request->input('applianceId');

        $this->dispatch(new AddApplianceToWishlistCommand($userId, $applianceId));

        return redirect()->route('frontend.wishlist', ['userId' => $userId]);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAppliance(Request $request, $userId)
    {
        if ($userId != access()->id()) {
            abort(403, 'You can only add appliances to your own wishlist');
        }

        $applianceId = $request->input('applianceId');

        $this->dispatch(new RemoveApplianceFromWishlistCommand($userId, $applianceId));

        return redirect()->route('frontend.wishlist', ['userId' => $userId]);
    }
}