<?php

namespace Modules\Catalog\Console;

use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Catalog\Notifications\Dashboard\OutStockListNotification;
use Illuminate\Console\Command;
use Notification;

class StockProductCommand extends Command
{
    protected $name = 'stock:outstock';

    protected $description = 'Out Of Stock Products.';

    public function __construct(Product $product)
    {
        $this->product = $product;
        parent::__construct();
    }

    public function handle()
    {
        $products = $this->product->outOfStockList();

        if (!is_null($products))
            Notification::route('mail', config('setting.contact_us.email'))->notify(new OutStockListNotification($products));
    }

}
