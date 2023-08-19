<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Inertia\Middleware;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // 文档
            'menus' => Menu::select('menu_name')
                ->get(),

            // 可用亮色主题
            'lightThemes' => [
                "light",
                // "dark",
                "cupcake",
                "bumblebee",
                "emerald",
                "corporate",
                // "synthwave",
                "retro",
                // "cyberpunk",
                "valentine",
                // "halloween",
                "garden",
                // "forest",
                // "aqua",
                "lofi",
                "pastel",
                "fantasy",
                "wireframe",
                // "black",
                // "luxury",
                // "dracula",
                "cmyk",
                "autumn",
                // "business",
                "acid",
                "lemonade",
                // "night",
                // "coffee",
                "winter",
            ],

            // 可用暗色主题
            'darkThemes' => [
                // "light",
                "dark",
                // "cupcake",
                // "bumblebee",
                // "emerald",
                // "corporate",
                // "synthwave",
                // "retro",
                // "cyberpunk",
                // "valentine",
                "halloween",
                // "garden",
                "forest",
                // "aqua",
                // "lofi",
                // "pastel",
                // "fantasy",
                // "wireframe",
                "black",
                "luxury",
                "dracula",
                // "cmyk",
                // "autumn",
                "business",
                // "acid",
                // "lemonade",
                "night",
                "coffee",
                // "winter",
            ],
        ]);
    }
}
