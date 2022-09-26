<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageStoreRequest;
use App\Models\Image;
use App\Models\Student;
use App\Models\Students;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function imageStore(ImageStoreRequest $request)
    {
        // $this->validate($request, [
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);

        $image_path = $request->file('image')->store('image', 'public');

        $data = Image::create([
            'image' => $image_path,
        ]);

        return response($data, Response::HTTP_CREATED);
    }

    public function student(Request $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $image = $request->file('photo');

        if ($request->hasFile('photo')) {
            $fileName = date('YmdHi'). '.'.$image->getClientOriginalExtension();
            $image->storeAs('photo',$fileName, 'public');
            $student['photo'] = $fileName;
        }else{
            return response()->json('image not found');
        }

        $student->save();
        return response()->json('done');
    }
}
