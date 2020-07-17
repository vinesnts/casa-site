<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sobre;
use Validator;
use App\Http\Requests\SobreRequest;
 
class SobreController extends Controller
{

    protected $sobre;

    public function __construct(Sobre $sobre)
    {
        $this->sobre = $sobre;
    } 

    public function sobre() 
    {
        $registro = $this->sobre->latest('updated_at')->first();
        return view('sobre', compact('registro'));
    }

    public function index() 
    {
        $registro = $this->sobre->latest('updated_at')->first();
        // $registros = $this->sobre->all()->reverse();
        if(!isset($registro)) {
            return view('admin.sobre.adicionar');
        }

        return view('admin.sobre.editar', compact('registro'));
    }

    public function adicionar() 
    {
        return view('admin.sobre.adicionar');
    }
    
    // Método responsavel por salvar as informacoes do formulario de criacao no banco de dados
    public function salvar(SobreRequest $request) 
    {

        $request->validated();
        $dados = $request->all();
    
        $sobrer = $this->sobre->create($dados);
        
        if($request->hasFile('logo')) {
            $anexo = $request->file('logo');
            $num = $sobre->id;
            $dir = 'img/logos';
            $ex = $anexo->guessClientExtension(); //Define a extensao do arquivo
            $nomeAnexo = 'logo_'.$num.'.'.$ex;
            $anexo->move($dir, $nomeAnexo);
            $dados['logo'] = $dir.'/'.$nomeAnexo;
        }

        if($request->hasFile('banner')) {
            $anexo = $request->file('banner');
            $num = $sobre->id;
            $dir = 'img/banner';
            $ex = $anexo->guessClientExtension(); //Define a extensao do arquivo
            $nomeAnexo = 'banner_'.$num.'.'.$ex;
            $anexo->move($dir, $nomeAnexo);
            $dados['banner'] = $dir.'/'.$nomeAnexo;
        }

        if($request->hasFile('anexo_sobre')) {
            $anexo = $request->file('anexo_sobre');
            $num = $sobre->id;
            $dir = 'img/anexo_sobre';
            $ex = $anexo->guessClientExtension(); //Define a extensao do arquivo
            $nomeAnexo = 'anexo_sobre_'.$num.'.'.$ex;
            $anexo->move($dir, $nomeAnexo);
            $dados['anexo_sobre'] = $dir.'/'.$nomeAnexo;
        }

        $sobre->update($dados);

        return redirect()->route('admin.sobre')->with('success', 'Informações adicionadas com sucesso!');
    }

    // Método responsavel por abrir a pagina de editar um evento
    public function editar($id) 
    {
        $registro = $this->sobre->find($id);
        return view('admin.sobre.editar', compact('registro'));
    }

    // Método responsavel por salvar as informacoes do formulario de edicao no banco de dados
    public function atualizar(SobreRequest $request, $id) 
    {
        $request->validated();
        $dados = $request->all();
        
        $dadoSite = $this->sobre->find($id);

        if($request->hasFile('logo')) {
            $anexo = $request->file('logo');
            $num = $dadoSite->id;
            $dir = 'img/logos';
            $ex = $anexo->guessClientExtension(); //Define a extensao do arquivo
            $nomeAnexo = 'logo_'.$num.'.'.$ex;
            $anexo->move($dir, $nomeAnexo);
            $dados['logo'] = $dir.'/'.$nomeAnexo;
        }

        if($request->hasFile('banner')) {
            $anexo = $request->file('banner');
            $num = $dadoSite->id;
            $dir = 'img/banner';
            $ex = $anexo->guessClientExtension(); //Define a extensao do arquivo
            $nomeAnexo = 'banner_'.$num.'.'.$ex;
            $anexo->move($dir, $nomeAnexo);
            $dados['banner'] = $dir.'/'.$nomeAnexo;
        }

        if($request->hasFile('anexo_sobre')) {
            $anexo = $request->file('anexo_sobre');
            $num = $dadoSite->id;
            $dir = 'img/anexo_sobre';
            $ex = $anexo->guessClientExtension(); //Define a extensao do arquivo
            $nomeAnexo = 'anexo_sobre_'.$num.'.'.$ex;
            $anexo->move($dir, $nomeAnexo);
            $dados['anexo_sobre'] = $dir.'/'.$nomeAnexo;
        }

        $dadoSite->touch();
        $dadoSite->update($dados);

        return redirect()->route('admin.index')->with('success', 'Informações atualizadas com sucesso!');
    }
}
