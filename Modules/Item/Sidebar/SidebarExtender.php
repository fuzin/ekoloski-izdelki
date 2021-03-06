<?php

namespace Modules\Item\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('item::items.title.items'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('item::items.title.items'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.item.item.create');
                    $item->route('admin.item.item.index');
                    $item->authorize(
                        $this->auth->hasAccess('item.items.index')
                    );
                });
                $item->item(trans('item::openingtimes.title.openingtimes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.item.openingtime.create');
                    $item->route('admin.item.openingtime.index');
                    $item->authorize(
                        $this->auth->hasAccess('item.openingtimes.index')
                    );
                });
// append


            });
        });

        return $menu;
    }
}
