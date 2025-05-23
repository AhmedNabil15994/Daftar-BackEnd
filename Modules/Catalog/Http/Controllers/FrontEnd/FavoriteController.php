<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Traits\FavoriteCartTrait;
use Modules\Catalog\Http\Requests\FrontEnd\CartRequest;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;

class FavoriteController extends Controller
{
    use FavoriteCartTrait;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $items =  app('favorite')->getContent()->sort();
        return view('catalog::frontend.favorites.index',compact('items'));
    }

    public function add(Request $request,$slug)
    {
        $product = $this->product->findBySlugWithoutVendorSlug($slug,$request);

        if(!$product)
            abort(404);

        $this->addToFavorite($product,$request);

        return \Response::json(["message" => __('catalog::frontend.favorites.add_succesfully')], 200);
    }

    public function delete(Request $request,$id)
    {
        $deleted =  $this->deleteProductFromFavorite($id);

        if ($deleted)
            return redirect()->back()->with(['alert'=>'success','status'=>__('catalog::frontend.favorites.delete_item')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('catalog::frontend.favorites.error_in_favorites')]);
    }

    public function clear(Request $request)
    {
        $cleared =  $this->clearFavorite();

        if ($cleared)
            return redirect()->back()->with(['alert'=>'success','status'=>__('catalog::frontend.favorites.clear_favorites')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('catalog::frontend.favorites.error_in_favorites')]);
    }
}
