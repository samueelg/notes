<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote(){
        return view('new_note');

    }

    public function newNoteSubmit(Request $request){
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
        ],
        [
            'text_title.required' => 'É necessario preencher o campo de titulo',
            'text_title.min' => 'O titulo deve ter no minimo :min caracteres',
            'text_title.max' => 'O titulo deve ter no maximo :man caracteres',
            'text_note.required' => 'É necessario preencher o campo de nota',
            'text_note.min' => 'A nota deve ter no minimo :min caracteres',
            'text_note.max' => 'A nota deve ter no maximo :max caracteres',
        ]
    );

    $id = session('user.id');

    $note = new Note();
    $note->user_id = $id;
    $note->title = $request->text_title;
    $note->text = $request->text_note;
    $note->save();
    return redirect()->route('home');
    }

    public function editNote($id){
        $id = Operations::decryptId($id);
        
        $note = Note::find($id);
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request){
        //Request validate para verificar os campos antes de dar update no banco
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
        ],
        [
            'text_title.required' => 'É necessario preencher o campo de titulo',
            'text_title.min' => 'O titulo deve ter no minimo :min caracteres',
            'text_title.max' => 'O titulo deve ter no maximo :man caracteres',
            'text_note.required' => 'É necessario preencher o campo de nota',
            'text_note.min' => 'A nota deve ter no minimo :min caracteres',
            'text_note.max' => 'A nota deve ter no maximo :max caracteres',
        ]
    );

        //Verifica se o id da nota é valido
        if($request->note_id == null){
            return redirect()->route('home');
        }

        $id = Operations::decryptId($request->note_id);

        //Carrega a nota do banco
        $note = Note::find($id);

        //Salva as alterações no banco
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();
        return redirect()->route('home');
    }

    public function deleteNote($id){
        $id = Operations::decryptId($id);
        echo "Deleting note with ID: $id";
    }
}
