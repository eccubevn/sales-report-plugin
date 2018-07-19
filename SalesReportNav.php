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

class SalesReportNav implements EccubeNav
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
                'id' => 'sales_report_admin',
                'name' => 'sales_report.nav.001',
                'has_child' => 'true',
                'icon' => 'fa-bar-chart',
                'child' => [
                    [
                        'id' => 'sales_report_admin_term',
                        'url' => 'sales_report_admin_term',
                        'name' => 'sales_report.nav.002',
                    ],
                    [
                        'id' => 'sales_report_admin_product',
                        'url' => 'sales_report_admin_product',
                        'name' => 'sales_report.nav.003',
                    ],
                    [
                        'id' => 'sales_report_admin_age',
                        'url' => 'sales_report_admin_age',
                        'name' => 'sales_report.nav.004',
                    ],
                ],
            ],
        ];
    }
}
