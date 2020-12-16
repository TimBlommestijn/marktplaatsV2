<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Intervention\Image\ImageManagerStatic as Image;


class ProductController extends Controller
{
    //function 2 get data for the homepage
    public function index(){
        $images = ProductImage::all();
        $products = DB::table('users')->join('products', 'users.id', 'products.uuid')
        ->select('products.*', 'users.name as author')->get();
        return Inertia::render('Home', ['products'=> $products->all(), 'images'=>$images]);
    }

    //function that returns a vue form 2 create an product
    public function create(){
        if (Auth::user()) {
            # code...
            return Inertia::render('CreateProduct');
        }
    }

    //function that stores a product in the database
    public function store(Request $request){
        if(Auth::user()){
            $product = new Product();
            $product->product_name = $request->input('name');
            $product->product_description = $request->input('description');
            $product->product_price = $request->input('price');
            $product->uuid = Auth::user()->id;
            $product->save();

            for($i = 0; $i< $request->input('imagesCount'); $i++){
                $image = $request->file('images_'.$i);
                // store image
                $ogName = $image->getClientOriginalName();                
                $theName = pathinfo($ogName, PATHINFO_FILENAME);
                $ext = $image->getClientOriginalExtension();
                $storeName = $theName.'_'.time().'.'.$ext;
                $image->storeAs('/product_images', $storeName, 'public');
                $image->storeAs('/product_images', "Thumbnail_".$storeName, 'public');
                $path = $image->storeAs('/product_images', $storeName, 'public');
                // dd(public_path());
                $img = Image::make(public_path().'/storage/product_images/Thumbnail_'.$storeName)->resize(null, 500 , function($constraint){
                    $constraint->aspectRatio();
                });
                $img->save();
                error_log("oi ".$storeName);
                // make a record
                $imageRecord = new ProductImage();
                $imageRecord->filePath = $path;
                $imageRecord->productId = $product->id;
                $imageRecord->save();
            }
            return redirect('dashboard');
        }
    }

    //function that returns all the products of a person
    public function dashboard(){
        $products = Product::where('uuid', '=' , Auth::user()->id)->get();
        $images = [];
        if(!Auth::user()->admin){
            foreach($products as $product){
                // dd($product->id);
                $image = ProductImage::where("ProductId", "=", $product->id)->first();
                array_push($images, $image);
            }
        }else if(Auth::user()->admin){
            $products = Product::all();
            $images = ProductImage::all();
        }
        return Inertia::render('Dashboard', ['products'=> $products , 'images' => $images]);
    }

    public function collection(){
        $products = Product::where('uuid', '=' , Auth::user()->id)->get();
        $images = [];
        if(!Auth::user()->admin){
            foreach($products as $product){
                // dd($product->id);
                $image = ProductImage::where("ProductId", "=", $product->id)->first();
                array_push($images, $image);
            }
            return json_encode([$images, $products]);
        }else if(Auth::user()->admin){
            $products = Product::all();
            $images = ProductImage::all();
            return json_encode([$images, $products]);
        }
    }

    //function that returns a specific product
    public function show($id){

        $product = Product::find($id);

        if(!$product){
            abort(404);
        }

        $images = ProductImage::where('productId', '=', $id)->get();
        return Inertia::render('Article', ['product'=> $product, "images"=> $images]);
    }

    //function that returns a form to edit a product
    public function edit($id){
        $product = new Product();
        $product = $product->find($id);
        if(Auth::user()->admin){
            return Inertia::render('EditProduct', [ 'product' => $product ]);
        }else if(Auth::user()->id == $product->uuid){
            return Inertia::render('EditProduct', [ 'product' => $product ]);
        }
    }

    //function that updates a product in the DB
    public function update(Request $request ,$id){

        Validator::make($request->all(), [
            'product_name' => ['required'],
            'product_description' => ['required'],
            'product_price' => ['required'],
        ])->validate();

        if(Auth::user()->admin || Auth::user()->id == $request->uuid){
            $product = Product::find($id);
            $product->product_name = $request->product_name;
            $product->product_description = $request->product_description;
            $product->product_price = $request->product_price;         
            $product->save();
            return Inertia::render('Dashboard');
        }
    }

    //function that deletes a product
    public function destroy($id){
        $product = Product::find($id);
        if(Auth::user()->admin || Auth::user()->id == $product->uuid){
            try {
                //code...
                $product->destroy($product->id);
                $images = ProductImage::where('productId', '=', $id)->get();
                // dd($images);
                foreach($images as $image){
                    File::delete(public_path().'/storage/'.$image->filePath);
                    ProductImage::destroy($image->id);
                }
                return redirect('/dashboard');
            } catch (\Throwable $th) {
                abort(500);
            }
        }
    }

}
