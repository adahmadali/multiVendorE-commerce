<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;
use File;
use Illuminate\Validation\Rules\Exists;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Brand::where('deleted_at', null)->latest()->get();
        return view('admin.brand.all_brand', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.add_brand');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'brand_name' => 'required|string|max:50|unique:brands',
            'brand_pay_of_line' => 'required|string|max:100',
            'brand_title' => 'required|string|max:100',
            'brand_description' => 'required|string|max:250',
            'brand_official_email' => 'required|max:100|email|unique:brands',
            'brand_official_phone' => 'required|min:10|unique:brands',
            'brand_official_address' => 'required|string',
        ]);


        $slug = Str::slug($request->brand_name);

        if ($request->hasFile('brand_image')) {

            $image = $request->file('brand_image');

            $customeName = "B".".".rand().time().".".$image->getClientOriginalExtension();
            $path = public_path('uploads/brand/'.$customeName);
            Image::make($image)->resize(250,250)->save($path);

            $insert = Brand::create([
                'brand_name' => $request->brand_name,
                'brand_pay_of_line' => $request->brand_pay_of_line,
                'brand_title' => $request->brand_title,
                'brand_description' => $request->brand_description,
                'brand_official_email' => $request->brand_official_email,
                'brand_official_phone' => $request->brand_official_phone,
                'brand_official_address' => $request->brand_official_address,
                'brand_slug' => $slug,
                'brand_image' => $customeName,
                'brand_creator' => Auth::user()->id,
                'created_at' => Carbon::now(),

            ]);

            if($insert){
                $notification = array(
                    'message' => "Brand Added Successfully",
                    'alert-type' => "success",
                );

            }else{
                $notification = array(
                    'message' => "Opps, Something is Wrong",
                    'alert-type' => "error",
                );
            }
            return redirect()->route('admin.all.brand')->with($notification);
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $data = Brand::where('brand_slug', $slug)->firstOrFail();
        return view('admin.brand.edit_brand', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $id = $request->id;

        $this->validate($request,[
            'brand_name' => 'required|string|max:50|unique:brands,brand_name,'.$id.'brand_name',
            'brand_pay_of_line' => 'required|string|max:100',
            'brand_title' => 'required|string|max:100',
            'brand_description' => 'required|string|max:250',
            'brand_official_email' => 'required|max:100|email|unique:brands,brand_official_email,'.$id.'brand_official_email',
            'brand_official_phone' => 'required|min:10|unique:brands,brand_official_phone,'.$id.'brand_official_phone',
            'brand_official_address' => 'required|string',
            'brand_status' => 'required',
        ]);



        $slug = Str::slug($request->brand_name);

        if ($request->hasFile('brand_image')) {

            $image = $request->file('brand_image');

            // delete old image
            $old_image = Brand::where('id', $id)->value('brand_image');

            if(File::exists(public_path('uploads/brand/'.$old_image))){
                File::delete(public_path('uploads/brand/'.$old_image));
            }

            $customeName = "B".".".rand().time().".".$image->getClientOriginalExtension();
            $path = public_path('uploads/brand/'.$customeName);
            Image::make($image)->resize(250,250)->save($path);

            $slug = Str::slug($request->brand_name);

            $insert = Brand::where('id', $id)->update([
                'brand_name' => $request->brand_name,
                'brand_pay_of_line' => $request->brand_pay_of_line,
                'brand_title' => $request->brand_title,
                'brand_description' => $request->brand_description,
                'brand_official_email' => $request->brand_official_email,
                'brand_official_phone' => $request->brand_official_phone,
                'brand_official_address' => $request->brand_official_address,
                'brand_slug' => $slug,
                'brand_image' => $customeName,
                'brand_status' => $request->brand_status,
                'brand_editor' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            if($insert){
                $notification = array(
                    'message' => "Brand Updated Successfully",
                    'alert-type' => "success",
                );

            }else{
                $notification = array(
                    'message' => "Opps, Something is Wrong",
                    'alert-type' => "error",
                );
            }
            return redirect()->route('admin.all.brand')->with($notification);
        }else{
            $update = Brand::where('id', $id)->update([
                'brand_name' => $request->brand_name,
                'brand_pay_of_line' => $request->brand_pay_of_line,
                'brand_title' => $request->brand_title,
                'brand_description' => $request->brand_description,
                'brand_official_email' => $request->brand_official_email,
                'brand_official_phone' => $request->brand_official_phone,
                'brand_official_address' => $request->brand_official_address,
                'brand_slug' => $slug,
                'brand_status' => $request->brand_status,
                'brand_editor' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            if($update){
                $notification = array(
                    'message' => "Brand Updated Successfully",
                    'alert-type' => "success",
                );

            }else{
                $notification = array(
                    'message' => "Opps, Something is Wrong",
                    'alert-type' => "error",
                );
            }
            return redirect()->route('admin.all.brand')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}