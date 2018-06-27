<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\SalesReport;

use Eccube\Common\EccubeNav;

class Nav implements EccubeNav
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getNav()
    {
        return [
            'customer' => [
                'id' => 'admin_plugin_sales_report',
                'name' => '売上集計',
                'has_child' => 'true',
                'icon' => 'cb-chart',
                'child' => [
                    [
                        'id' => 'admin_plugin_sales_report_term',
                        'url' => 'admin_plugin_sales_report_term',
                        'name' => '期間別集計',
                    ],
                    [
                        'id' => 'admin_plugin_sales_report_product',
                        'url' => 'admin_plugin_sales_report_product',
                        'name' => '商品別集計',
                    ],
                    [
                        'id' => 'admin_plugin_sales_report_age',
                        'url' => 'admin_plugin_sales_report_age',
                        'name' => '年代別集計',
                    ],
                ],
            ],
        ];
    }
}
