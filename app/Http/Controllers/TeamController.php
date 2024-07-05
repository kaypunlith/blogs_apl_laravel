<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Teamimage;

class TeamController extends Controller
{
    public function store(Request $request){
    
      //  $validator=Validator::make($request->all(),[
      //   'image'=>'reqiired|image'
      //  ]);
      //  if($validator->fails()){
      //     return response()->json([
      //       'statius'=>false,
      //       'message'=>"Erorr for create data",
      //       'erorr'=>$validator->erorrs()
      //     ]);

      //  }
//        //upload image
       $image=$request->image;
       $ext=$image->getClientOriginalExtension();
       $imageName=time().'.'.$ext;

       //stor Image infor 
       $teamImage=new Teamimage();
       $teamImage->name=$imageName;
       $teamImage->save();
       $image->move(public_path('uploads/temp'),$imageName);
       return response()->json([
        'statius'=>true,
        'message'=>"Insert image successfully",
        'iamge'=>$teamImage
      ]);
    }
}
