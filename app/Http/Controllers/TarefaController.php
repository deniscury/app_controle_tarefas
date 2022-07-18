<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Mail;
use App\Mail\NovaTarefaMail;

use PDF; 
use Excel;
use App\Exports\TarefasExport;

class TarefaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        /*
        if(auth()->check()){
            $id = auth()->user()->id;
            $name = auth()->user()->name;
            $email = auth()->user()->email;


            return "ID $id - Nome $name - Email $email";
        }
        

        if(Auth::check()){
            $id = Auth::user()->id;
            $name = Auth::user()->name;
            $email = Auth::user()->email;

            return "ID $id - Nome $name - Email $email";
        }

        $id = Auth::user()->id;
        $name = Auth::user()->name;
        $email = Auth::user()->email;
        */
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(3);

        return view('tarefa.index', array('tarefas' => $tarefas));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $regras = array(
            'tarefa' => 'required',
            'data_limite_conclusao' => 'required|date_format:Y-m-d|after:yesterday'
        );        

        $feedback = array(
            'required' => 'O campo :attribute é obrigatório',
            'data_limite_conclusao.date_format' => 'Data inválida',
            'data_limite_conclusao.after' => 'Você não pode cadastrar datas anteriores a hoje'
        );

        $request->validate($regras, $feedback);

        $dados = $request->all();
        $dados['user_id'] = auth()->user()->id;

        $tarefa = Tarefa::create($dados);

        $destinatario = auth()->user()->email; // email do usuário logado

        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', array('tarefa' => $tarefa->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        //
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        //
        $user_id = auth()->user()->id;
        if ($tarefa->user_id != $user_id){
            return view('acesso-negado');
        }

        return view('tarefa.edit', array(
            'tarefa' => $tarefa
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        //
        $user_id = auth()->user()->id;
        if ($tarefa->user_id != $user_id){
            return view('acesso-negado');
        }

        $regras = array(
            'tarefa' => 'required',
            'data_limite_conclusao' => 'required|date_format:Y-m-d|after:yesterday'
        );        

        $feedback = array(
            'required' => 'O campo :attribute é obrigatório',
            'data_limite_conclusao.date_format' => 'Data inválida',
            'data_limite_conclusao.after' => 'Você não pode cadastrar datas anteriores a hoje'
        );

        $request->validate($regras, $feedback);

        $tarefa->update($request->all());

        return redirect()->route('tarefa.show', array(
            'tarefa' => $tarefa
        ));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        //
        $user_id = auth()->user()->id;
        if ($tarefa->user_id != $user_id){
            return view('acesso-negado');
        }

        $tarefa->delete();

        return redirect()->route('tarefa.index'); 
    }

    public function exportar($ext){
        
        if (!in_array($ext, array('xlsx', 'csv', 'pdf', 'dompdf'))){
            return redirect()->route('tarefa.index');
        }

        if ($ext == 'dompdf'){
            $tarefas = auth()->user()->tarefas()->get();

            $pdf = PDF::loadView('tarefa.pdf', array('tarefas' => $tarefas));

            $pdf->setPaper('a4', 'landscape');

            return $pdf->stream('lista_de_tarefas.pdf');
            //return $pdf->download('lista_de_tarefas.pdf');
        }

        return Excel::download(new TarefasExport(), "lista_de_tarefas.$ext");
    }
}
