<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DeliveryTime\Entities\DeliveryStatus;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $all = [
                [
                    'flag' => 'pending',
                    'title' => [
                        'ar' => 'قيد الإنتظار',
                        'en' => 'Pending',
                    ],
                ],
                [
                    'flag' => 'preparing',
                    'title' => [
                        'ar' => 'جارى التحضير',
                        'en' => 'Preparing',
                    ],
                ],
                [
                    'flag' => 'out_for_delivery',
                    'title' => [
                        'ar' => 'خارج للتوصيل',
                        'en' => 'Out For Delivery',
                    ],
                ],
                [
                    'flag' => 'complete',
                    'title' => [
                        'ar' => 'الطلب مكتمل',
                        'en' => 'Complete',
                    ],
                ],
                [
                    'flag' => 'cancelled',
                    'title' => [
                        'ar' => 'تم إلغاء الطلب',
                        'en' => 'Cancelled',
                    ],
                ],
            ];

            $count = DeliveryStatus::count();

            if ($count == 0) {
                foreach ($all as $k => $item) {
                    $titles = $item['title'];
                    unset($item['title']);
                    $deliveryObject = DeliveryStatus::create($item);
                    foreach ($titles as $locale => $value) {
                        $deliveryObject->translateOrNew($locale)->title = $value;
                    }
                    $deliveryObject->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
