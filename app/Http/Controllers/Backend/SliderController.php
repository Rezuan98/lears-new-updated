<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class SliderController extends Controller
{   const IMAGE_WIDTH = 1200;
    const IMAGE_HEIGHT = 400;


    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('back-end.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('back-end.slider.create');
    }

  


  

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0'
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Create new ImageManager instance with GD driver
                $manager = new ImageManager(new Driver());
                
                // Process the image
                $processedImage = $manager->read($image->getRealPath())
                    ->resize(self::IMAGE_WIDTH, self::IMAGE_HEIGHT, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                
                // Ensure directory exists
                if (!file_exists(public_path('uploads/sliders'))) {
                    mkdir(public_path('uploads/sliders'), 0777, true);
                }

                // Save the processed image
                $processedImage->save(public_path('uploads/sliders/' . $filename));

                Slider::create([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'image' => $filename,
                    'link' => $request->link,
                    'order' => $request->order ?? 0,
                    'status' => true
                ]);

                Toastr::success('Slider created successfully!');
                return redirect()->route('sliders.index');
            }
        } catch (\Exception $e) {
            Toastr::error('Failed to create slider: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0'
        ]);

        try {
            $slider = Slider::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
                    unlink(public_path('uploads/sliders/' . $slider->image));
                } $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Create new ImageManager instance
                $manager = new ImageManager(new Driver());
                
                // Process the image
                $processedImage = $manager->read($image->getRealPath())
                    ->resize(self::IMAGE_WIDTH, self::IMAGE_HEIGHT, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });$processedImage->save(public_path('uploads/sliders/' . $filename));
                
                    $slider->image = $filename;
                }
    
                $slider->title = $request->title;
                $slider->subtitle = $request->subtitle;
                $slider->link = $request->link;
                $slider->order = $request->order ?? $slider->order;
                $slider->save();
    
                Toastr::success('Slider updated successfully!');
                return redirect()->route('sliders.index'); } catch (\Exception $e) {
                    Toastr::error('Failed to update slider: ' . $e->getMessage());
                    return redirect()->back()->withInput();
                }
            }
    // ... rest of your controller methods remain the same ...


    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('back-end.slider.edit', compact('slider'));
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'nullable|string|max:255',
    //         'subtitle' => 'nullable|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'link' => 'nullable|url|max:255',
    //         'order' => 'nullable|integer|min:0'
    //     ]);

    //     try {
    //         $slider = Slider::findOrFail($id);

    //         if ($request->hasFile('image')) {
    //             // Delete old image
    //             if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
    //                 unlink(public_path('uploads/sliders/' . $slider->image));
    //             }

    //             // Upload new image
    //             $image = $request->file('image');
    //             $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    //             $image->move(public_path('uploads/sliders'), $filename);
    //             $slider->image = $filename;
    //         }

    //         $slider->title = $request->title;
    //         $slider->subtitle = $request->subtitle;
    //         $slider->link = $request->link;
    //         $slider->order = $request->order ?? $slider->order;
    //         $slider->save();

    //         Toastr::success('Slider updated successfully!');
    //         return redirect()->route('sliders.index');

    //     } catch (\Exception $e) {
    //         Toastr::error('Failed to update slider: ' . $e->getMessage());
    //         return redirect()->back()->withInput();
    //     }
    // }

    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            
            // Delete image file
            if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
                unlink(public_path('uploads/sliders/' . $slider->image));
            }
            
            $slider->delete();
            
            Toastr::success('Slider deleted successfully!');
            return redirect()->route('sliders.index');
        } catch (\Exception $e) {
            Toastr::error('Failed to delete slider: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $slider = Slider::findOrFail($request->slider_id);
            $slider->status = $request->status;
            $slider->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status!'
            ]);
        }
    }
}