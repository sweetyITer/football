<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 17:59
 */
namespace app\api\address;

use app\AppApi;
use mmapi\core\Db;
use model\entity\Region;

class regionList extends AppApi
{
    protected function init()
    {
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $type     = [
            'province' => 1,
            'city'     => 2,
            'district' => 3,
        ];
        $pro_list = Db::create()->sqlBuilder()
            ->select('region_id,region_name')
            ->from('mall_region')
            ->where('status')
            ->eq(1)
            ->andWhere('region_type')
            ->eq($type['province'])
            ->fetchAll();
        $data     = [];
        foreach ($pro_list as $k => $v) {
            $regionId = $v['region_id'];
            $province = $v['region_name'];
            /** @var Region $item */
            $region = Region::getRepository()->findBy(['parentId' => $regionId, 'status' => 1, 'regionType' => $type['city']]);
            foreach ($region as $item) {
                $c_regionId               = $item->getRegionId();
                $city                     = $item->getRegionName();
                $list                     = Db::create()->sqlBuilder()
                    ->select('region_id,region_name')
                    ->from('mall_region')
                    ->where('parent_id')
                    ->eq($c_regionId)
                    ->andWhere('status')
                    ->eq(1)
                    ->andWhere('region_type')
                    ->eq($type['district'])
                    ->fetchAll();
                $data[$k]['province']     = $province;
                $data[$k]['province_id']  = $regionId;
                $data [$k]['city_list'][] =
                    [
                        'city'          => $city,
                        'city_id'       => $c_regionId,
                        'district_list' => $list,
                    ];

            }
        }
        $this->set('data', $data);
    }
}