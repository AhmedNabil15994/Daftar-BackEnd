<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Catalog\Http\Requests\FrontEnd\CartRequest;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;

class ShoppingCartController extends Controller
{
    use ShoppingCartTrait;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $items = Cart::getContent();
        return view('catalog::frontend.shopping-cart.index',compact('items'));
    }

    public function totalCart()
    {
        return Cart::getSubTotal();
    }

    public function headerCart()
    {
        return view('apps::frontend.layouts._cart');
    }


    public function createOrUpdate(CartRequest $request,$slug)
    {
        $product = $this->product->findBySlugWithoutVendorSlug($slug,$request);

        if(!$product)
            abort(404);

        if (!is_null($product->variantChosed))
          $errors =  $this->addOrUpdateCartVariants($product,$request);
        else
          $errors =  $this->addOrUpdateCart($product,$request);

        if ($errors)
          return \Response::json(["errors" => $errors->getMessageBag()->toArray()], 422);

          return \Response::json(["message" => __('catalog::frontend.cart.add_succesfully')], 200);
    }

    public function delete(Request $request,$id)
    {
        $deleted =  $this->deleteProductFromCart($id);

        if ($deleted)
            return redirect()->back()->with(['alert'=>'success','status'=>__('catalog::frontend.cart.delete_item')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('catalog::frontend.cart.error_in_cart')]);
    }

    public function clear(Request $request)
    {
        $cleared =  $this->clearCart();

        if ($cleared)
            return redirect()->back()->with(['alert'=>'success','status'=>__('catalog::frontend.cart.clear_cart')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('catalog::frontend.cart.error_in_cart')]);
    }
}
