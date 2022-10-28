<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $settings = Setting::all();
        return Response()->view('admin.settings.index',['settings' => $settings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'title' => 'required|string|min:3',
            'instagram' => 'required|string|min:3',
            'facebook' => 'required|string|min:3',
            'twitter' => 'required|string|min:3',
            'youtube' => 'required|string|min:3',
            'email' => 'required|email|unique:settings,email',
            'mobile' => 'required|numeric|min:3',
            'whatsapp' => 'required|numeric|min:3',
            'sales_manager_mobile' => 'required|numeric|min:3',
            'customer_followup_mobile' => 'required|numeric|min:3',
            'disributor_mobile' => 'required|numeric|min:3',
            'location' => 'required|string|min:3',
            'site_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'boss_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'boss_words' => 'required|string|min:10',
            'boss_name' => 'required|string|min:5',
        ]);

        if (!$validator->fails()) {
            $setting = new Setting();
            $setting->title = $request->input('title');
            $setting->instagram = $request->input('instagram');
            $setting->facebook = $request->input('facebook');
            $setting->twitter = $request->input('twitter');
            $setting->youtube = $request->input('youtube');
            $setting->email = $request->input('email');
            $setting->mobile = $request->input('mobile');
            $setting->whatsapp = $request->input('whatsapp');
            $setting->sales_manager_mobile = $request->input('sales_manager_mobile');
            $setting->customer_followup_mobile = $request->input('customer_followup_mobile');
            $setting->disributor_mobile = $request->input('disributor_mobile');
            $setting->location = $request->input('location');
            $setting->boss_words = $request->input('boss_words');
            $setting->boss_name = $request->input('boss_name');
            if ($request->hasFile('site_image')) {
                $file = $request->file('site_image');
                $imageName = time() . '_Setting_image.' . $file->getClientOriginalExtension();
                $request->file('site_image')->storePubliclyAs('images/Settings', $imageName);
                $imagePath = 'images/Settings/' . $imageName;
                $setting->site_image = $imagePath;
            }
            if ($request->hasFile('boss_image')) {
                $file = $request->file('boss_image');
                $imageName = time() . '_Setting_image.' . $file->getClientOriginalExtension();
                $request->file('boss_image')->storePubliclyAs('images/Settings', $imageName);
                $imagePath = 'images/Settings/' . $imageName;
                $setting->boss_image = $imagePath;
            }
            $isSaved = $setting->save();
            return response()->json(
                ['message' => $isSaved ? 'Updated Successfully' : 'Update failed!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
        return response()->view('admin.settings.edit', ['setting' => $setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
        $validator = Validator($request->all(), [
            'title' => 'required|string|min:3',
            'instagram' => 'required|string|min:3',
            'facebook' => 'required|string|min:3',
            'twitter' => 'required|string|min:3',
            'youtube' => 'required|string|min:3',
            'email' => 'required|email|unique:settings,email,' . $setting->id,
            'mobile' => 'required|numeric|min:3',
            'whatsapp' => 'required|numeric|min:3',
            'sales_manager_mobile' => 'required|numeric|min:3',
            'customer_followup_mobile' => 'required|numeric|min:3',
            'disributor_mobile' => 'required|numeric|min:3',
            'location' => 'required|string|min:3',
            'site_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'boss_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'boss_words' => 'required|string|min:10',
            'boss_name' => 'required|string|min:5',
        ]);

        if (!$validator->fails()) {
            $setting->title = $request->input('title');
            $setting->instagram = $request->input('instagram');
            $setting->facebook = $request->input('facebook');
            $setting->twitter = $request->input('twitter');
            $setting->youtube = $request->input('youtube');
            $setting->email = $request->input('email');
            $setting->mobile = $request->input('mobile');
            $setting->whatsapp = $request->input('whatsapp');
            $setting->sales_manager_mobile = $request->input('sales_manager_mobile');
            $setting->customer_followup_mobile = $request->input('customer_followup_mobile');
            $setting->disributor_mobile = $request->input('disributor_mobile');
            $setting->location = $request->input('location');
            $setting->boss_words = $request->input('boss_words');
            $setting->boss_name = $request->input('boss_name');
            if ($request->hasFile('site_image')) {
                Storage::delete($setting->site_image);
                $file = $request->file('site_image');
                $imageName = time() . '_setting_image.' . $file->getClientOriginalExtension();
                $request->file('site_image')->storePubliclyAs('images/settings', $imageName);
                $imagePath = 'images/settings/' . $imageName;
                $setting->site_image = $imagePath;
            }
            if ($request->hasFile('boss_image')) {
                Storage::delete($setting->boss_image);
                $file = $request->file('boss_image');
                $imageName = time() . '_setting_image.' . $file->getClientOriginalExtension();
                $request->file('boss_image')->storePubliclyAs('images/settings', $imageName);
                $imagePath = 'images/settings/' . $imageName;
                $setting->boss_image = $imagePath;
            }
            $isSaved = $setting->save();
            return response()->json(
                ['message' => $isSaved ? 'Updated Successfully' : 'Update failed!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
