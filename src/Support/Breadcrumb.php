<?php

namespace Tltcms\Support;

use Illuminate\Support\Facades\Config;

class Breadcrumb
{
    /**
     * @var array
     */
    private array $breadcrumb;

    /**
     * @var bool
     */
    private bool $show;

    public function __construct()
    {
        $config['home'] = Config::get('tltcms.homeroute', 'home');
        $config['title'] = settings('title', 'Title');
        $config['json'] = settings('json-name','Json name');

        $this->breadcrumb[] = [
            'name' => '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg>',
            'nameJson' => $config['json'],
            'link' => route($config['home']),
            'title' => $config['title']
        ];

        $this->show = false;
    }

    /**
     * Put to breadcrumb
     *
     * @param $name
     * @param $link
     * @param $title
     * @return void
     */
    public function put($name, $link, $title = null): void
    {
        $this->show = true;

        $this->breadcrumb[] = [
            'name' => $name,
            'nameJson' => trim(strip_tags($name)),
            'link' => $link,
            'title' => $title
        ];
    }

    /**
     * Render HTML
     * @return string
     */
    public function render(): string
    {
        return $this->show ? view('tltcms::modules.breadcrumb.html', ['breadcrumb' => $this->breadcrumb])->render() : '';
    }

    /**
     * Render ld+json schema.org breadcrumb
     * @return string
     */
    public function renderJson(): string
    {
        return $this->show ? view('tltcms::modules.breadcrumb.json', ['breadcrumb' => $this->breadcrumb])->render() : '';
    }
}
