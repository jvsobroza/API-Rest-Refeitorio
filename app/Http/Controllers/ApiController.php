<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrbitalRequest;
use App\Models\Orbital;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //getRefeições - order by data
    //getRefeiçõesByData
    //postRefeições
    //putRefeições
    //deleteRefeições
    public function getRefeicoes()
    {
        $refeicoes = Orbital::orderBy('data', 'asc')->get()->toJson(JSON_PRETTY_PRINT);
        return response($refeicoes, 200);
    }
    public function getRefeicoesByData($data)
    {
        $refeicoes = Orbital::where('data', $data)->get();
        return response()->json($refeicoes);
    }
    public function postRefeicoes(Request $request)
    {
        if ($request->turno != 'cafe' && $request->turno != 'almoco' && $request->turno != 'janta') {
            return response()->json([
                "message" => "Turno inválido. Os valores permitidos são: cafe, almoco, janta."
            ], 400);
        } else {
            $refeicao = new Orbital();
            $refeicao->data = $request->data;
            $refeicao->refeicao = $request->refeicao;
            $refeicao->turno = $request->turno;
            $refeicao->save();

            return response()->json([
                "message" => "Refeição inserida com sucesso"
            ], 201);
        }
    }
}
