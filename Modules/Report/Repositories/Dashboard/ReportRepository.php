<?php

namespace Modules\Report\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;

class ReportRepository
{
    public function __construct()
    {
    }

    public function productSales($request)
    {
        $type = "";
        if (isset($request['req']['type']) && $request['req']['type'] != '') {
            $type = $request['req']['type'];
        }
        $locale = locale();
        $products = DB::table("order_products")->
            select(
            DB::raw(
                "product_translations.title as title  ,
                        products.id  as vendor_id    ,
                        products.qty  as product_stock    ,
                        products.image  as image    ,
                        \"product\" as type ,
                        order_products.id  as id ,
                        order_products.qty  as qty ,
                        order_products.total  as total ,
                        order_products.price  as price ,
                        order_products.sale_price  as sale_price ,
                        order_products.original_total  as original_total ,
                        order_products.total_profit  as total_profit ,
                        order_products.created_at  as created_at  ,
                        order_products.order_id as order_id ,
                        products.sku  as sku,
                        order_variants.product_variant_id
                "
            )
        )
            ->join("products", "products.id", "=", "order_products.product_id")
            ->leftJoin("order_variants", "order_products.id", "=", "order_variants.order_product_id")
            ->join("vendors", "products.vendor_id", "=", "vendors.id")
            ->join("product_translations", function ($join) use ($request) {
                $join->on("products.id", "=", "product_translations.product_id")
                    ->where("product_translations.locale", locale());
            });

        $products = $this->filterDateTableDate($products, "order_products", $request);
        $products = $this->searchProductNameDaTable($products, $request);
        return $products;
    }

    public function filterDateTableDate($query, $table, $request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate($table . '.created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate($table . '.created_at', '<=', $request['req']['to']);
        }

        return $query;
    }

    public function searchProductNameDaTable($query, $request)
    {
        $query->when($request->input('search.value'), function ($query) use ($request) {
            $query->whereExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->where('product_translations.title', 'like', '%' . $request->input('search.value') . '%')
                    ->from('product_translations')
                    ->whereColumn('products.id', 'product_translations.product_id');
            });
        });

        return $query;
    }

}
