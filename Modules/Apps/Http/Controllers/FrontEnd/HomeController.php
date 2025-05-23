<?php

namespace Modules\Apps\Http\Controllers\FrontEnd;

use Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Requests\FrontEnd\ContactUsRequest;
use Modules\Apps\Notifications\FrontEnd\ContactUsNotification;
use Modules\PopupAdds\Repositories\FrontEnd\PopupAddsRepository as PopupAdds;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;

class HomeController extends Controller
{
    protected $popupAdd;
    protected $category;
    protected $product;

    public function __construct(PopupAdds $popupAdd, Category $category, Product $product)
    {
        $this->popupAdd = $popupAdd;
        $this->category = $category;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*$randomAdvertLink = '#';
        $randomAdvert = $this->popupAdd->getRandomAdvert($request);

        if (!is_null($randomAdvert)) {
            if (is_null($randomAdvert->morph_model)) {
                $randomAdvertLink = $randomAdvert->link;
            } elseif ($randomAdvert->morph_model == 'Category') {
                $category = $this->category->findById($randomAdvert->popupable_id);
                $randomAdvertLink = route('frontend.categories.show', $category->translate(locale())->slug);
            } elseif ($randomAdvert->morph_model == 'Product') {
                $product = $this->product->findById($randomAdvert->popupable_id);
                $randomAdvertLink = route('frontend.products.index', [$product->vendor->translate(locale())->slug, $product->translate(locale())->slug]);
            }
        }*/
        return view('apps::frontend.index');
    }

    public function contactUs()
    {
        return view('apps::frontend.contact-us');
    }

    public function sendContactUs(ContactUsRequest $request)
    {
        Notification::route('mail', config('setting.contact_us.email'))
            ->notify((new ContactUsNotification($request))->locale(locale()));

        return redirect()->back()->with(['status' => __('apps::frontend.contact_us.alerts.send_message')]);
    }
}
