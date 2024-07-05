<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Teamimage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show(){
           $getallblogs=Blogs::orderBy('created_at','DESC')->get();
          return response()->json([
            'status'=>true,
            'message'=>'Getall blogs successfully',
            'data'=>$getallblogs
          ]);
        
    }
    public function create(Request $request){     
          // $validator=Validator::make($request->all(),[
          //    'title'=>'required|min:3',
          //    'auther'=>'required|min:2'
          // ]);
          // if($validator->errors()){
          //       return response()->json([
          //           'status'=>false,
          //           'message'=>"Please Fex error",
          //           'error'=>$validator->errors()
          //       ]);
          // }
          $addblogs=new Blogs();
          $addblogs->title=$request->title;
           $addblogs->shortDes=$request->shortDes;
          // $addblogs->image=$request->image;
         $addblogs->description=$request->description;
         $addblogs->auther=$request->auther;
         $addblogs->save();
         //save image
         $tempImage=Teamimage::find($request->image_id);

         if($tempImage!=null){
          $imageArray=explode('.',$tempImage->name);
          $ext=last($imageArray);
          $imageName=time().'-'.$addblogs->id.'.'.$ext;
          $addblogs->image=$imageName;
          $addblogs->save();
          $sourcePath=public_path('uploads/temp/'.$tempImage->name);
          $desPath=public_path('uploads/blogs/'.$imageName);
          File::copy($sourcePath,$desPath);
         }
         return response()->json(
            [
                "status"=>true,
                "message"=>"create data successfully",
                "Data"=>$addblogs
             ]
            );
    }
    public function showone($id){
      $showone=Blogs::find($id);
      if($showone==null){
          return response()->json([
            'status'=>false,
            'message'=>'This blogs notFound',
            
          ]);
      }
      return response()->json([
           'status'=>true,
            'message'=>'blogs was Found',
            'data'=>$showone
      ]);
    }
    public function edit($id,Request $request){
      $edite=new Blogs();
      $edite=Blogs::find($id);
      if($edite==null){
          return response()->json([
            'status'=>false,
            'message'=>'Erro for update'
          ]);
      }
      $edite->title=$request->title;
      $edite->shortDes=$request->shortDes;
     $edite->image=$request->image;
     $edite->description=$request->description;
     $edite->auther=$request->auther;
     $edite->save();

       //save image
       $tempImage=Teamimage::find($request->image_id);
       if($tempImage!=null){
        $imageArray=explode('.',$tempImage->name);
        $ext=last($imageArray);
        $imageName=time().'-'.$edite->id.'.'.$ext;
        $edite->image=$imageName;
        $edite->save();
        $sourcePath=public_path('uploads/temp/'.$tempImage->name);
        $desPath=public_path('uploads/blogs/'.$imageName);
        File::copy($sourcePath,$desPath);
       }
       return response()->json(
          [
              "status"=>true,
              "message"=>"Edit data successfully",
              "Data"=>$edite
           ]
          );
    }
    public function Delete($id){
      $blogs=new Blogs();
      $blogs=Blogs::find($id);
      $blogs->delete();
      if($blogs){
        return response()->json([
          'status'=>true,
          'meesaage'=>'Delete completed',
        ]);
      }
    }

}
