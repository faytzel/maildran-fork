<?php

declare(strict_types=1);

namespace App\Services;

use Route;
use Lang;
use Request;
use Config;
use stdClass;

class ViewLayoutService
{
    protected $robots = true;

    public function title(bool $tagline = true) : string
    {
        $title = null;

        // obtenemos el alias del controlador
        $routeName = $this->routeName();

        // si existe la ruta en el fichero de lang
        if (!is_null($routeName) && Lang::has('title.routes.' . $routeName)) {
            $title = Lang::get('title.routes.' . $routeName);
        // sino, titulo por defecto
        } else {
            $title = Lang::get('title.default');
        }

        // coletilla del titulo
        if ($tagline) {
            $title .= Lang::get('title.tagline');
        }

        return $title;
    }

    public function description() : string
    {
        // obtenemos el alias del controlador
        $routeName = $this->routeName();

        // si existe la ruta en el fichero de lang
        if (!is_null($routeName) && Lang::has('description.routes.' . $routeName)) {
            return Lang::get('description.routes.' . $routeName);
        }

        // sino, descripcion por por defecto
        return Lang::get('description.default');
    }

    public function robots() : string
    {
        if ($this->robots) {
            return 'index,follow';
        }

        return 'noindex,follow';
    }

    public function openGraph() : stdClass
    {
        $data = new stdClass();

        $data->title       = $this->title(false);
        $data->url         = Request::fullUrl();
        $data->description = $this->description();
        $data->image       = asset('img/logo/300.png');
        $data->siteName    = Config::get('app.name');
        $data->domain      = Config::get('app.domains.web');

        return $data;
    }

    protected function routeName() : ?string
    {
        // obtenemos el alias del controlador y lo parseamos
        $routeName = Route::currentRouteName();
        if (!is_null($routeName)) {
            $routeName = preg_replace('/^get\./', '', $routeName);
            $routeName = preg_replace('/\./', '-', $routeName);
        }

        return $routeName;
    }
}
