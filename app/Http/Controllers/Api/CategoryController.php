<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function createcategory(Request $request){


      

       $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }


      try{

        
        $category = Category::create(['name' => $request->name]);

       
        return response()->json(['message' => 'Category Created Successfully']);

        }catch(QueryException $e){
            
            return response()->json(['message' => $e->getMessage()]);
        }
       
       
    }

    public function updatecategory(Request $request,Category $category){
    
        $datas = json_decode($request->getContent(), true);
        

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }


        try{
                // update the genre with the new values
                $category = Category::find($category->id);
                $category->name = $datas['name'];
               
                // update other fields here
                $category->save(); 

                return response()->json(['message' => 'Category Updated Successfully']);

            }catch(QueryException $e){
                
                return response()->json(['message' => $e->getMessage()]);
            }
    
        
    }

    public function destory(Category $category){
        try{
            $category->delete();

            return redirect()->route('categories')->with('success','Delete Category Successfully');
        }catch(QueryException $e){
            if ($e->errorInfo[1] == 1451) {
                return back()->withErrors(['error' => 'Cannot delete this Category because it is referenced by another Video.']);
            } else {
                return back()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }
}
