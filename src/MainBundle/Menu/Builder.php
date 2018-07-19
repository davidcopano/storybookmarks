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

        $menu = $factory->createItem('root');
        $menu->addChild($bookmarks, ['route' => 'bookmarks_list']);
        $menu->addChild($folders, ['route' => 'folders_list']);
        $menu->addChild($tags, ['route' => 'tags_list']);

        return $menu;
    }
}