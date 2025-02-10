<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
	public function create(){
	    $info = Setting::first();
	    return view('back-end.setting.create', [
	        'action' => $info ? route('setting.update', $info->id) : route('setting.store'), 
	        'method' => $info ? 'PATCH' : 'POST', 
	        'create' => $info ? 'Edit setting' : 'Create setting',
	        'btn_name' => $info ? 'Update' : 'Submit',
	        'info' => $info
	    ]);
	}


	  public function store(Request $request){

	    $info = new Setting();
	    $info->name = $request->name;
	    $info->email = $request->email;
	    $info->phone = $request->phone;
	    $info->address = $request->address;

	    $path = public_path('back-end/setting/');
	    $fileFields = ['logo'];

	    foreach ($fileFields as $field) {
	        if ($request->hasFile($field)) {
	            $file = $request->$field;
	            $fileName = time() . '.' . $file->getClientOriginalName();
	            $file->move($path, $fileName);
	            $info->$field = $fileName;
	        }
	    }

	    $info->save();
	    return redirect()->route('setting.create');
	}

	public function edit($id){
	    $info = Setting::findOrFail($id);
	    return view('back-end.setting.create', [
	        'info' => $info, 
	        'action' => route('setting.update', $info->id), 
	        'method' => 'PATCH', 
	        'create' => 'Edit setting',
	        'btn_name' => 'Update',
	    ]);
	}


	public function update(Request $request, $id){

	    $info = Setting::findOrFail($id);
	    $info->name = $request->name;
	    $info->email = $request->email;
	    $info->phone = $request->phone;
	    $info->address = $request->address;
	    
	    $path = public_path('back-end/setting/');
	    $fileFields = ['logo'];

	    foreach ($fileFields as $field) {
	        if ($request->hasFile($field)) {
	            $oldFilePath = $info->$field ? $path . $info->$field : null;

	            if ($oldFilePath && file_exists($oldFilePath)) {
	                @unlink($oldFilePath);
	            }

	            $fileName = time() . '.' . $request->$field->getClientOriginalName();
	            $request->$field->move($path, $fileName);
	            $info->$field = $fileName;
	        }
	    }
	    
	    $info->save();
	    return redirect()->route('setting.create');
	}

}
