<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function editNote($id)
    {
        // $id = $this->decryptId($id);
        $id = Operations::decryptId($id);
        // Load note
        $note = Note::find($id);


        // show edit note view
        return view('edit_note', ['note' => $note]);

    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        echo "I'm inside the delete note! . $id";
    }

    public function newNote()
    {

        return view('new_note');
    }
    public function newNoteSubmit(Request $request)
    {

        //validade request
        $request->validate(
            //Rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            //error messages
            [
                'text_title.required' => 'Title is required',
                'text_title.min' => 'Password must be at least :min characters',
                'text_title.max' => 'Password must be at most :max characters',
                'text_note.required' => 'Note is required',
                'text_note.min' => 'Note must be at least :min characters',
                'text_note.max' => 'Note must be at most :max characters',
            ]
        );
        // get user id
        $id = session('user.id');
        //create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();
        // redirect to home
        return redirect()->route('home');
    }
}
