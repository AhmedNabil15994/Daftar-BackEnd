<?php

namespace Modules\Order\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Traits\OrderCalculationTrait;

class OrderRepository
{
    use OrderCalculationTrait, ShoppingCartTrait;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function successOrders()
    {
        return $this->order->where('order_status_id', 7)->count();
    }

    public function failedOrders()
    {
        return $this->order->where('order_status_id', 8)->count();
    }

    public function returnedOrders()
    {
        return $this->order->where('order_status_id', 6)->count();
    }

    public function canceledOrders()
    {
        return $this->order->where('order_status_id', 4)->count();
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date_create"))
            ->groupBy('date_create')
            ->pluck('date_create');

        $ordersIncome = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->select(DB::raw("sum(total) as profit"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order
            ->with('orderStatus')
            ->select("order_status_id", DB::raw("count(id) as count"))
            ->groupBy('order_status_id')
            ->get();

        foreach ($orders as $order) {

            $status = $order->orderStatus->translate(locale())->title;
            $order->type = $status;
        }

        $data["ordersCount"] = json_encode(array_pluck($orders, 'count'));
        $data["ordersType"] = json_encode(array_pluck($orders, 'type'));

        return $data;
    }

    public function completeOrders()
    {
        $orders = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })->count();

        return $orders;
    }

    public function totalProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->orderBy($order, $sort)->get();
        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order
            ->with([
                'orderProducts.product',
                'orderProducts.orderVariant.orderVariantValues.variantValue.optionValue.option',
            ])->withDeleted()->find($id);

        return $order;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);

        $order->update([
            'unread' => true,
        ]);
    }

    public function updateDriver($request, $id)
    {
        DB::beginTransaction();
        try {
            $order = $this->findById($id);
            $mainOrderData = [];

            if ($request['order_status'] != '') {
                $mainOrderData['order_status_id'] = $request['order_status'];
            }

            if ($request['delivery_status_id']) {
                $mainOrderData['delivery_status_id'] = $request['delivery_status_id'];
            }

            if ($request['time']) {
                $mainOrderData['time'] = $request['time'];
            }

            if ($request['notes']) {
                $mainOrderData['notes'] = $request['notes'];
            }

            if (!empty($mainOrderData)) {
                $order->update($mainOrderData);
            }

            if ($request['payment_method'] != '') {
                $order->transactions()->update([
                    'method' => $request['payment_method'],
                ]);
            }

            $order->driver()->delete();
            if ($request['user_id']) {
                $order->driver()->updateOrCreate([
                    'user_id' => $request['user_id'],
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete();
            else:
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->order->where('order_status_id', '!=', 7);
        $query->where(function ($query) use ($request) {

            $query->where('id', 'like', '%' . $request->input('search.value') . '%');

            $query->orWhere(function ($query) use ($request) {

                $query->whereHas('orderAddress', function ($query) use ($request) {
                    $query->where('username', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                });
            });

            $query->orWhere(function ($query) use ($request) {

                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                });
            });

            $query->orWhere(function ($query) use ($request) {

                $query->whereHas('orderProducts.product', function ($query) use ($request) {
                    $query->where('sku', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhereHas('translations', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                    });
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function QueryTable2($request)
    {
        $query = $this->order
            ->where('order_status_id', 7);
        $query->where(function ($query) use ($request) {

            $query->where('id', 'like', '%' . $request->input('search.value') . '%');

            $query->orWhere(function ($query) use ($request) {

                $query->whereHas('orderAddress', function ($query) use ($request) {
                    $query->where('username', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                });
            });

            $query->orWhere(function ($query) use ($request) {

                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                });
            });

            $query->orWhere(function ($query) use ($request) {

                $query->whereHas('orderProducts.product', function ($query) use ($request) {
                    $query->where('sku', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhereHas('translations', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                    });
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['req']['from'])) {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to'])) {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['driver'])) {
            $query->whereHas('driver', function ($query) use ($request) {
                $query->where('user_id', $request['req']['driver']);
            });
        }

        if (isset($request['req']['vendor_id'])) {
            $query->where('vendor_id', $request['req']['vendor_id']);
        }

        if (isset($request['req']['status_id'])) {
            $query->where('order_status_id', $request['req']['status_id']);
        }

        if (isset($request['req']['payment_type'])) {
            $query->whereHas('transactions', function ($query) use ($request) {
                $query->where('method', $request['req']['payment_type']);
            });
        }

        if (isset($request['req']['payment_status']) && !empty($request['req']['payment_status'])) {
            $paymentStatus = $request['req']['payment_status'] == 'paid' ? ['CAPTURED', 'CASH'] : ['NOT CAPTURED', 'ERROR'];
            $query->whereHas('transactions', function ($query) use ($paymentStatus) {
                $query->whereIn('result', $paymentStatus);
            });
        }

        return $query;
    }

    public function updateDeliveryStatus($request, $order)
    {
        DB::beginTransaction();
        try {
            $orderData = ['delivery_status_id' => $request['delivery_status_id']];
            $order->update($orderData);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getSelectedOrdersById($ids)
    {
        $orders = $this->order
            ->with([
                'orderProducts',
                'user',
                'orderAddress',
                'driver',
                'vendor',
                'transactions',
                'orderCoupon',
            ]);

        $orders = $orders->whereIn('id', $ids)->get();
        return $orders;
    }
}
