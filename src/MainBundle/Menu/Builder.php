<?php

namespace MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $translator = $this->container->get('translator');

        $bookmarks = $translator->trans('menu.items.bookmarks');
        $folders = $translator->trans('menu.items.folders');
        $tags = $translator->trans('menu.items.tags');
        $optionsString = $translator->trans('menu.items.options');

        $menu = $factory->createItem('root');
        $menu->addChild($bookmarks, ['route' => 'bookmarks_list', 'extras' => ['icon' => 'fas fa-star']]);
        $menu->addChild($folders, ['route' => 'folders_list', 'extras' => ['icon' => 'fas fa-folder']]);
        $menu->addChild($tags, ['route' => 'tags_list', 'extras' => ['icon' => 'fas fa-tag']]);
        $menu->addChild($optionsString, ['route' => 'options_index', 'extras' => ['icon' => 'fas fa-cogs']]);

        return $menu;
    }
}