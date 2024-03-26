<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Message;
use Illuminate\Http\Request;

class mensajeController extends Controller
{
    public function index()
    {
        $articulos = Message::all();
        return response()->json($articulos);
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = new Message();
        $message->sender_id = $request->input('sender_id');
        $message->receiver_id = $request->input('receiver_id');
        $message->message = $request->input('message');
        $message->save();

        return response()->json(['message' => 'Mensaje enviado con éxito']);

        
    }

    public function index3()
    {
        $usuarioAutenticado = auth()->user();
        $usuarioId = $usuarioAutenticado->original;
        if (auth()->check()) {
            $usuarioAutenticado = auth()->user();
            $usuarioId = $usuarioAutenticado->id;
            dd($usuarioId);
        } else {
            dd("No hay na");
         }
    }

    public function getMessages(Request $request)
    {
        $senderId = $request->input('sender_id');
        $receiverId = $request->input('receiver_id');

        $messages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->orderBy('created_at', 'asc')->get();
        return response()->json(['messages' => $messages]);
    }
}
