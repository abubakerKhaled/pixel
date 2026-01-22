<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArtistsToFollow extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        $artists = [
            ['img' => 'alessia', 'name' => 'Alessia', 'handle' => 'alessia_draws'],
            ['img' => 'anne', 'name' => 'Anne', 'handle' => 'just_anne'],
            ['img' => 'mr-anderson', 'name' => 'Mr. Anderson', 'handle' => 'Mr. Anderson'],
            ['img' => 'michael', 'name' => 'Michael', 'handle' => 'Michael'],
        ];
        return view('components.artists-to-follow', compact('artists'));
    }
}