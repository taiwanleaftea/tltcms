<?php

namespace Tltcms\Support;

use Exception;
use Illuminate\Support\Facades\Config;

class MainMenu
{
    /**
     * @var array
     */
    protected array $menu = [];

    /**
     * MainMenu constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function init(): void
    {
        $home = route(Config::get('tltcms.homeroute', 'home'));
        $menu = Config::get('tltcms.mainmenu', []);
        $submenu = Config::get('tltcms.submenu', []);

        $this->menu = [];

        if (Config::get('tltcms.mainmenu_home', true)) {
            $this->put(
                name: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/><path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/></svg>',
                link: $home,
                key: 'home'
            );
        }

        foreach ($menu as $item) {
            $link = $item['is_href'] ? $item['link'] : route($item['link']);
            $this->put(
                name: $item['name'],
                link: $link,
                key: $item['key']
            );
        }

        foreach ($submenu as $item) {
            $collection = $item['model']::enabled()->ordered()->get();

            foreach ($collection as $submenuItem) {
                $this->submenu(
                    key: $item['key'],
                    name: $submenuItem->{$item['name']},
                    link: route($item['route'], $submenuItem->{$item['parameter']})
                );
            }
        }
    }

    /**
     * Store menu item
     * @param string $name
     * @param string $link
     * @param string $key
     * @param bool $isActive
     */
    public function put(string $name, string $link, string $key, bool $isActive = false): void
    {
        $this->menu[$key] = [
            'name' => $name,
            'link' => $link,
            'active' => $isActive
        ];
        $this->menu[$key]['submenu'] = [];
    }

    /**
     * @param string $key
     * @return void
     * @throws Exception
     */
    public function remove(string $key): void
    {
        if (isset($this->menu[$key])) {
            unset($this->menu[$key]);
        } else {
            throw new Exception($key . ' not found in menu');
        }
    }

    /**
     * @param string $key
     * @param string $name
     * @param string $link
     * @return void
     * @throws Exception
     */
    public function submenu(string $key, string $name, string $link): void
    {
        if (isset($this->menu[$key])) {
            $this->menu[$key]['submenu'][] = [
                'name' => $name,
                'link' => $link
            ];
        } else {
            throw new Exception($key . ' not found in menu');
        }
    }

    /**
     * Render menu
     * @return string
     */
    public function render(): string
    {
        return view('tltcms::modules.mainmenu.html', ['menu' => $this->menu])->render();
    }

    /**
     * @param string $key
     * @return void
     * @throws Exception
     */
    public function setActive(string $key): void
    {
        if (isset($this->menu[$key])) {
            foreach ($this->menu as $item) {
                $item['active'] = false;
            }
            $this->menu[$key]['active'] = true;
        } else {
            throw new Exception($key . ' not found in menu');
        }
    }
}
