<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/27
 * Time: 09:37
 */

namespace tests;

use GuzzleHttp\Client;
use mmapi\core\Config;
use model\entity\Product;
use PHPUnit\Framework\TestCase;

class productTest extends TestCase
{
    public function test1()
    {
        $arr1 = [
            [
                'id'     => '344',
                'value'  => '黑色',
                'attrId' => '10',
            ],
            [
                'id'     => '345',
                'value'  => '32',
                'attrId' => '11',
            ],
            [
                'id'     => '346',
                'value'  => '5.5',
                'attrId' => '12',
            ],
            [
                'id'     => '347',
                'value'  => '6',
                'attrId' => '12',
            ],
        ];

        $arr2 = [
            [
                'attrId' => '10',
                'value'  => '黑色',
                'id'     => '344',
            ],
            [
                'attrId' => '11',
                'value'  => '32',
                'id'     => '345',
            ],
            [
                'attrId' => '11',
                'value'  => '34',
                'id'     => '0',
            ],
            [
                'attrId' => '12',
                'value'  => '5.5',
                'id'     => '346',
            ],
            [
                'attrId' => '12',
                'value'  => '6',
                'id'     => '347',
            ],
        ];
        foreach ($arr1 as &$item) {
            ksort($item);
        }
        foreach ($arr2 as &$item) {
            ksort($item);
        }

//        foreach ($arr2 as $i) {
//            echo 122;
//            var_dump(in_array($i, $arr1));
//        }
    }

}