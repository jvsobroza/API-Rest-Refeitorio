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
        $refeicoes = Orbital::orderBy('data', 'asc')->where('data', '>=', date('Y-m-d'))->get()->toJson(JSON_PRETTY_PRINT);
        return response($refeicoes, 200);
    }
    public function getRefeicoesByData($data)
    {
        $refeicoes = Orbital::where('data', $data)->get();
        return response()->json($refeicoes);
    }
    public function postRefeicoes(Request $request)
    {
        if ($request->turno < 1 || $request->turno > 3) {
            return response()->json([
                "message" => "Turno inválido. Os valores permitidos são: 1 (café), 2 (almoço), 3 (jantar)."
            ], 400);
        } 
        if ($request->data < date('Y-m-d')) {
            return response()->json([
                "message" => "Data inválida. A data deve ser igual ou posterior à data atual."
            ], 400);
        }
        $dataExists = Orbital::where('data', $request->data)->where('turno', $request->turno)->exists();
        if ($dataExists) {
            return response()->json([
                "message" => "Já existe uma refeição cadastrada para esta data e turno."
            ], 400);
        }
        else {
            try {
                $refeicao = new Orbital();
                $refeicao->data = $request->data;
                $refeicao->refeicao = $request->refeicao;
                $refeicao->complemento = $request->complemento;
                $refeicao->turno = $request->turno;
                $refeicao->save();

                return response()->json([
                    "message" => "Refeição inserida com sucesso"
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => "Erro ao inserir a refeição: " . $e->getMessage()
                ], 500);
            }
        }
    }

    public function putRefeicoes(Request $request, $id)
    {
        $refeicao = Orbital::find($id);
        if (!$refeicao) {
            return response()->json([
                "message" => "Refeição não encontrada."
            ], 404);
        }
        if ($request->turno < 1 || $request->turno > 3) {
            return response()->json([
                "message" => "Turno inválido. Os valores permitidos são: 1 (café), 2 (almoço), 3 (jantar)."
            ], 400);
        } 
        if ($request->data < date('Y-m-d')) {
            return response()->json([
                "message" => "Data inválida. A data deve ser igual ou posterior à data atual."
            ], 400);
        }
        $dataExists = Orbital::where('data', $request->data)->where('turno', $request->turno)->where('id', '!=', $id)->exists();
        if ($dataExists) {
            return response()->json([
                "message" => "Já existe uma refeição cadastrada para esta data e turno."
            ], 400);
        }
        else {
            try {
                $refeicao->data = $request->data;
                $refeicao->refeicao = $request->refeicao;
                $refeicao->complemento = $request->complemento;
                $refeicao->turno = $request->turno;
                $refeicao->save();

                return response()->json([
                    "message" => "Refeição atualizada com sucesso"
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => "Erro ao atualizar a refeição: " . $e->getMessage()
                ], 500);
            }
        }
    }

    public function deleteRefeicoes($id)
    {
        $refeicao = Orbital::find($id);
        if (!$refeicao) {
            return response()->json([
                "message" => "Refeição não encontrada."
            ], 404);
        }
        try {
            $refeicao->delete();
            return response()->json([
                "message" => "Refeição deletada com sucesso"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Erro ao deletar a refeição: " . $e->getMessage()
            ], 500);
        }
    }
}
