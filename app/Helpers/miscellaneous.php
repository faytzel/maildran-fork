<?php

declare(strict_types=1);

use App\Exceptions\Helpers\MiscellaneousException;
use Symfony\Component\HttpKernel\Exception\HttpException;

function app_version() : ?string
{
    if (!App::isLocal() && Cache::has('app.version')) {
        return Cache::get('app.version');
    }

    $process = new Symfony\Component\Process\Process(
        'git --git-dir=' . base_path('.git') . ' describe master --match="v*"'
    );
    $process->setTimeout(10);
    $process->run();

    // comprobamos que no haya habido un error en el comando
    if (!$process->isSuccessful()) {
        Log::error('app_version - Command cannot run - ' . $process->getErrorOutput());
        return null;
    }

    // obtenemos la version
    $version = trim($process->getOutput());

     // comprobamos que sea valida la version
    if (!preg_match('/^v[0-9]+\.[0-9]+\.[0-9]+$/', $version)) {
        Log::error('app_version - Version not valid - ' . $version);
        return null;
    }

    // cacheamos la version
    Cache::forever('app.version', $version);

    // devolvemos la version
    return $version;
}

function repo(string $name)
{
    $binding = 'App\Contracts\Repositories\\' . Stringy::upperCaseFirst($name) . 'RepositoryContract';

    return App::make($binding);
}

function c_empty($collection) : bool
{
    // filter by types valid
    if (!$collection instanceof Illuminate\Database\Eloquent\Model
        && !$collection instanceof Illuminate\Database\Eloquent\Collection
        && !is_null($collection)
    ) {
        throw new MiscellaneousException('$collection type error');
    }

    if (count($collection) == 0) {
        return true;
    }

    return false;
}

function c_any($collection) : bool
{
    return !c_empty($collection);
}

function c_one(?\Illuminate\Database\Eloquent\Model $collection) : bool
{
    if (count($collection) == 1) {
        return true;
    }

    return false;
}

function array_to_object(array $array) : stdClass
{
    return (object) $array;
}

function class_key(string $className, string $suffix) : string
{
    $classNameClean = explode('\\', $className);
    $classNameClean = array_slice($classNameClean, -1, 1)[0];
    $classNameClean = preg_replace('/' . preg_quote($suffix, '/') . '$/', '', $classNameClean);
    $classNameClean = Stringy::lowerCaseFirst($classNameClean);

    return $classNameClean;
}

function cookie_consent_accepted()
{
    if (Cookie::has('cookieconsent_status') && Cookie::get('cookieconsent_status') == 'allow') {
        return true;
    }

    return false;
}

function matches(string $pattern, string $text) : array
{
    preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

    return $matches;
}

function match_any(array $matches) : bool
{
    if (count($matches) > 0) {
        return true;
    }

    return false;
}

function navigator_ajax(?HttpException $exception) : bool
{
    $statusCode = 200;
    if (!is_null($exception)) {
        $statusCode = $exception->getStatusCode();
    }

    if (cookie_consent_accepted() && $statusCode === 200) {
        return true;
    }

    return false;
}
