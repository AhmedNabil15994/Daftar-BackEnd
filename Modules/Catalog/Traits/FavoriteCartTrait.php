<?php

namespace Modules\Catalog\Traits;

use Cart;
use Illuminate\Support\MessageBag;
use Darryldecode\Cart\CartCondition;

trait FavoriteCartTrait
{
    public function findItemById($product)
    {
        $item = app('favorite')->getContent()->get($product->id);
        return $item;
    }

    public function addToFavorite($product,$request)
    {
        $addToCart = app('favorite')->add([
          'id'          => $product->id,
          'name'        => $product->translate(locale())->title,
          'price'       => $product->price,
          'quantity'    => 1,
          'attributes'  => [
              'sku'         => $product->sku,
              'image'       => $product->image,
              'slug'        => $product->translate(locale())->slug,
              'translation' => $product->translations,
              'old_price'   => $product->offer ? $product->price : null,
              'product'     => $product,
          ]
        ]);

        return $addToCart;
    }

    public function deleteProductFromFavorite($productId)
    {
        $cartItem =  app('favorite')->remove($productId);

        if (count(app('favorite')->getContent()) <= 0)
          return $this->clearCart();

        return $cartItem;
    }

    public function clearFavorite()
    {
        app('favorite')->clear();

        return true;
    }
}
