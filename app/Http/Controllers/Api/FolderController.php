<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folder;
use PHPUnit\Exception;

class FolderController extends Controller
{
    public function getListFolder(){
        try {
            $listFolder = Folder::all();
            return response()->json([
                'status_code' => 200,
                'data'=>$listFolder
            ]);

        }
        catch (Exception $e){
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function createFolder(Request $request)
    {
        try {
            $result = Folder::create([
                'folder_name' => $request['folder-name'],
            ]);
            if ($result) {
                return response()->json([
                    'status_code' => 200,
                    'message' => "create group card success"
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => "Folder is exist"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateFolder(Request $request, $id)
    {
        try {
            $folder = Folder::find($id);
            $folder->folder_name = $request['folder-name'];
            $folder->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Update Card is success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function deleteFolder($id)
    {
        try {
            $folder = Folder::find($id);
            $result = $folder->delete();
            if($result){
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Delete Folder is success'
                ]);
            }
            return response()->json([
                'status_code' => 500,
                'message' => 'Delete Folder is failure'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
}
