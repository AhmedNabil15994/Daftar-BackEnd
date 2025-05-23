<?php

namespace Modules\Catalog\Console;

use Modules\Catalog\Notifications\Dashboard\AlertOutStockListNotification;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Illuminate\Console\Command;
use Notification;

class AlertStockProductCommand extends Command
{
    protected $name = 'stock:underlimit';

    protected $description = 'Stock Qty Under The Limit';

    public function __construct(Product $product)
    {
        $this->product = $product;
        parent::__construct();
    }

    public function handle()
    {
        $products = $this->product->alertOutOfStockList();

        if (!is_null($products))
            Notification::route('mail', config('setting.contact_us.email'))->notify(new AlertOutStockListNotification($products));
    }

}
