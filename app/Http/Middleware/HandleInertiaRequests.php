<?php

namespace App\Http\Middleware;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => fn (): array => [
                'user' => $request->user()?->load('profile'),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success', false)
            ],
            'artistsToFollow' => function () use ($request): array {
                $currentProfile = $request->user()?->profile;

                if (! $currentProfile) {
                    return [];
                }

                $followingIds = $currentProfile->following()->pluck('following_profile_id');

                return ProfileResource::collection(
                    Profile::whereNotIn('id', $followingIds)
                        ->where('id', '!=', $currentProfile->id)
                        ->inRandomOrder()
                        ->limit(5)
                        ->get()
                )->resolve();
            },
        ];
    }
}
