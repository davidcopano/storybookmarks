<?php

namespace MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Psr\Container\ContainerInterface;

class Builder
{
    private $factory;
    private $container;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     * @param ContainerInterface $container
     */
    public function __construct(FactoryInterface $factory, $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }

    public function mainMenu(array $options)
    {
        $translator = $this->container->get('translator');

        $bookmarks = $translator->trans('menu.items.bookmarks');
        $folders = $translator->trans('menu.items.folders');
        $tags = $translator->trans('menu.items.tags');
        $optionsString = $translator->trans('menu.items.options');

        $menu = $this->factory->createItem('root');
        $menu->addChild($bookmarks, ['route' => 'bookmarks_list', 'extras' => ['icon' => 'fas fa-star']]);
        $menu->addChild($folders, ['route' => 'folders_list', 'extras' => ['icon' => 'fas fa-folder']]);
        $menu->addChild($tags, ['route' => 'tags_list', 'extras' => ['icon' => 'fas fa-tag']]);
        $menu->addChild($optionsString, ['route' => 'options_index', 'extras' => ['icon' => 'fas fa-cogs']]);

        return $menu;
    }
}