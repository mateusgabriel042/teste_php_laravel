<?php
namespace App\Helper;
use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;

class Helpers{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    }


    public static function getHeaderApis(){
        $category = new Category();
        // dd($category);

            ?>

            <li>
            <a href="javascript:void(0);">Markers<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php

                            ?>
                            <!-- <li> </a>
                                <ul class="dropdown sub-dropdown border-0 shadow">

                                    <li><a href=""> </a></li>
                                    <li><a href=""> </a></li>
                                    <li><a href=""> </a></li>
                                    <li><a href=""> </a></li>
                                    <li><a href=""> </a></li>
                                    <li><a href=""> </a></li>
                                    <li><a href=""> </a></li>

                                </ul>
                            </li> -->

                                <?php
                                    echo '<li><a href="'.route("api.casasbahia").'">Casas Bahia</a></li>
                                    <li><a href="'.route("api.mercadolibrarie").'">Mercado Librarie</a></li>
                                    <li><a href="'.route("api.amazon").'">Amazon</a></li>
                                    <li><a href="'.route("api.magalu").'">Magalu</a></li>
                                    <li><a href="'.route("api.olist").'">Olist</a></li>
                                    <li><a href="'.route("api.shopee").'">Shopee</a></li>
                                    <li><a href="'.route("api.americanas").'">Americanas</a></li>';
                                ?>
                            <?php


                    ?>
                </ul>
            </li>
        <?php

    }

    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>

            <li>
            <a href="javascript:void(0);">Categoria<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    public static function postTagList($option='all'){
        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
    }

    public static function postCategoryList($option="all"){
        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id=''){

        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::with('product')->where('user_id',$user_id)->where('order_id',null)->get();
        }
        else{
            return 0;
        }
    }
    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id=''){

        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return 0;
        }
    }
    public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }


    public static function uploadImage($file, $disk = 'images_products')
    {
        $extensions = ['jpg', 'jpeg', 'png', 'bmp', 'tiff']; // all extension type for images

        $isImage = $file->getClientOriginalExtension();
        if (!in_array($isImage, $extensions)) {
            return false;
        }

        $fileName = time() . '-' . $file->hashName();

        $upload = Storage::disk($disk)->put($fileName, File::get($file));
        if ($upload) {
            return $fileName;
        }

        return false;

    }

    public static function uploadImageCloud($image)
    {
        $API_KEY = '1268c8786c5ad74790b9d0bb943bd567';
        $fileName = time() . '-' . $image->hashName();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $data = array('image' => base64_encode(file_get_contents($image)), 'name' => $fileName);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        if ($response['success'] = true) {
            return $response['data']['display_url'];
        } else {
            return false;
        }


    }


    public static function formatMoney($str)
    {
        return "R$ " . number_format($str, 2, ',', '.');
    }

    public static function getPrice($price)
    {
        if($price <= 3){
            $value = $price + ($price * 2);
            $value = $value + ($price * 0.21) + 6;
            return  $value;
        }
        else if($price <= 6){
            $value = $price + ($price * 1.5);
            $value = $value + ($price * 0.21) + 6;
            return  $value;
        }
        else if($price <= 10){
            $value = $price + ($price * 1);
            $value = $value + ($price * 0.21) + 6;
            return  $value;
        }
        else if($price <= 15){
            $value = $price + ($price * 0.8);
            $value = $value + ($price * 0.21) + 6;
            return  $value;
        }
        else if($price <= 20){
            $value = $price + ($price * 0.7);
            $value = $value + ($price * 0.21) + 6;
            return  $value;
        }
        else if($price <= 30){
            $value = $price + ($price * 0.6);
            $value = $value + ($price * 0.21) + 6;
            return  $value;
        }
        else if($price <= 40){
            $value = $price + ($price * 0.55);
            $value = $value + ($price * 0.21) + 19;
            return  $value;
        }
        else if($price <= 50){
            $value = $price + ($price * 0.45);
            $value = $value + ($price * 0.21) + 19;
            return  $value;
        }
        else if($price <= 65){
            $value = $price + ($price * 0.40);
            $value = $value + ($price * 0.21) + 19;
            return  $value;
        }
        else if($price <= 70){
            $value = $price + ($price * 0.38);
            $value = $value + ($price * 0.21) + 24;
            return  $value;
        }
        else if($price <= 100){
            $value = $price + ($price * 0.35);
            $value = $value + ($price * 0.21) + 24;
            return  $value;
        }
        else if($price <= 200){
            $value = $price + ($price * 0.33);
            $value = $value + ($price * 0.21) + 24;
            return  $value;
        }
        else if($price <= 400){
            $value = $price + ($price * 0.3);
            $value = $value + ($price * 0.21) + 36;
            return  $value;
        }
        else if($price <= 600){
            $value = $price + ($price * 0.28);
            $value = $value + ($price * 0.21) + 36;
            return  $value;
        }
        else if($price <= 1000){
            $value = $price + ($price * 0.25);
            $value = $value + ($price * 0.21) + 49;
            return  $value;
        }
        else if($price <= 2000){
            $value = $price + ($price * 0.2);
            $value = $value + ($price * 0.21) + 56;
            return  $value;
        }
        else if($price <= 4000){
            $value = $price + ($price * 0.19);
            $value = $value + ($price * 0.21) + 71;
            return  $value;
        }
        else if($price <= 6000){
            $value = $price + ($price * 0.17);
            $value = $value + ($price * 0.21) + 89;
            return  $value;
        }
        else if($price <= 10000){
            $value = $price + ($price * 0.15);
            $value = $value + ($price * 0.21) + 122;
            return  $value;
        }
        else {
            $value = $price + ($price * 0.12);
            $value = $value + ($price * 0.21) + 138.90;
            return  $value;
        }
    }

    public static function getImages($name)
    {
        $url = "https://www.google.com/search?q=" . str_replace(' ', '+', $name) . "&tbm=isch";
        $data_code = "";
        try {
        $html = file_get_contents($url);
        $DOM = new \DOMDocument();
        $DOM->loadHTML(utf8_encode($html));
        $data = $DOM->getElementsByTagName('img');
        $count = 0;
        foreach ($data as $dat) {
            if (strpos($dat->getAttribute('class'), 'yWs4tf') === 0) {
                $count++;
                $data_code .= $dat->getAttribute('src');
                if ($count == 6) {
                    break;
                }

            }
        }
        } catch (\Throwable $th) {
            //throw $th;
        }

        // $data_code = "ERROR API IMAGES";
        return $data_code;
    }


}

?>
