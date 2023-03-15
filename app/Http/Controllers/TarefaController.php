<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyUserTarefa;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarefasExport;
use Barryvdh\DomPDF\Facade\Pdf;


class TarefaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefa = Tarefa::where('user_id', auth()->user()->id)->paginate(10);

        return view('tarefa.index', ['tarefas' => $tarefa]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request->validate(
            [
                'tarefa' => ['required', 'min:3'],
                'data_limite_conclusao' => ['required', 'date']
            ],
            [
                'tarefa.required' => 'Preencha o campo Tarefa',
                'data_limite_conclusao.required' => 'Preecnha o campo de Data'
            ]
        );

        $dados = $request->all();
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show', $tarefa->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa'=> $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        if(!Gate::allows('update-tarefa', $tarefa)){
            return redirect()->route('tarefa.index');
        }
        return view('tarefa.edit', ['tarefa' => $tarefa]);
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
        if(!Gate::allows('update-tarefa', $tarefa)){
            return redirect()->route('tarefa.index');
        }
        $request->validate(
            [
                'tarefa' => ['required', 'min:3'],
                'data_limite_conclusao' => ['required', 'date']
            ],
            [
                'tarefa.required' => 'Preencha o campo Tarefa',
                'data_limite_conclusao.required' => 'Preecnha o campo de Data'
            ]
        );

        $tarefa->update($request->all());

        return redirect()->route('tarefa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {

        if(!Gate::allows('update-tarefa', $tarefa)){
            return redirect()->route('tarefa.index');
        }
        $tarefa->delete($tarefa->id);

        return redirect()->route('tarefa.index');
    }

    public function exportacao(Request $request){

        $ext = $request->ext;

        if($ext != 'xlsx' && $ext != 'csv' && $ext != 'pdf'){
            return redirect()->route('tarefa.index');
        }

        return Excel::download(new TarefasExport, "tarefas.$ext");
    }
    
    public function exportar(Request $request){
        $tarefas = auth()->user()->tarefas()->get();
        $pdf = Pdf::loadView('pdf.tarefa', ['tarefas' => $tarefas]);

        $pdf->setPaper('a4', 'portrait');
        //return $pdf->download('tarefa.pdf');
        return $pdf->stream('tarefa.pdf');
    }
}
