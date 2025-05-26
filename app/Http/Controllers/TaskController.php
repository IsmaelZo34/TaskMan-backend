<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->tasks()->orderBy('id','desc')->get();
    }
    public function show(Request $request, $id){
        $task = $request->user()->tasks()->findorFail($id);
        if($task){
            return response()->json($task);
        }
        // Au cas ou tache non trouvé, on renvoye juste un erreur 404 et on va gerer avec React
        return response()->json(['Tache innéxistant'], 404);
    }
    public function store(Request $request){
        //utiliser $request->user() pour avoir l'utilisateur connecté grace au token
        $task = $request->user()->tasks()->create($request->all());
        return response()->json($task,201);
    }
    public function update(Request $request, $id){
        $task = $request->user()->tasks()->findOrFail($id);
        if($task){
            $maj = $task->update($request->all());
            return response()->json($maj);
        }
        return response()->json(['Tache introuvable'], 404);
    }
    public function destroy(Request $request, $id){
        $task = $request->user()->tasks()->findorFail($id);
        if($task){
            $task->delete();
            return response()->json(['message'=>'Tache supprimée avec succès']);
        }    
        return response()->json(['TAche introuvable'],404);
    }
}
