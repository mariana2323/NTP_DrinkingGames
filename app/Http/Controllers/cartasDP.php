<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cartas;
use App\reglas;
use App\reglas_x_juegos;
use App\jugador;
use App\puntaje;
use phpDocumentor\Reflection\Types\Array_;

class cartasDP extends Controller
{

    function agregarReglas(Request $request){
        $reglas = new reglas;
        //$jugador->id = 0;
        $reglas->descripcion = $request->input('descripcion');
        $reglas->detalle = $request->input('detalle');
        $reglas->save();
        return Array('result'=>$reglas);
    }
    function eliminarReglaJuego($idJuego, $idRegla){
        $regla = reglas_x_juegos::where("id_juego", $idJuego)->where("id_reglas", $idRegla)->delete();
        return Array("success"=>true);
    }
    function agregarReglasJuegos(Request $request){
        $reglasjuego = new reglas_x_juegos;
        //$jugador->id = 0;
        $reglasjuego->id_reglas = $request->input('id_reglas');
        $reglasjuego->id_juego = $request->input('id_juego');
        $reglasjuego->save();
        return Array('result'=>$reglasjuego);
    }

    function agregarCartas(Request $request){
        $cartas = new cartas;
        //$jugador->id = 0;
        $cartas->numero = $request->input('numero');
        $cartas->palo = $request->input('palo');
        $cartas->imagen = $request->input('imagen');
        $cartas->save();
        return Array('result'=>$cartas);
    }

    function cascada()
    {

        $jugadores= \App\jugador::all();
        $cartas = \App\cartas::all();
        $cartasDesor[0]=null;
        $aux=$this->desordenarCartas($cartas);
        $regla[0]=null;
        $todo[][]=null;
        $count=0;
        for($i=0;$i<count($cartas);$i++)
        {
            if($count>=count($jugadores))
                $count=0;

                $cartasDesor[$i] = $cartas[$aux[$i]];
                $regla[$i] = $this->obtenerRegla($cartasDesor[$i]->id);
                $todo[$i][0] = $cartasDesor[$i];
                $todo[$i][1] = $regla[$i];
                $todo[$i][2]=$jugadores[$count];
                $count++;

        }
        $todo1=Array('data'=>$todo);
        return json_encode($todo1);

    }
    function modificarPuntaje(Request $request)
    {
        $puntajeCartas = puntaje::select("puntajes_cartas")->where("id_jugador", $request->input('id_jugador'))->get();
        $resul = puntaje::where("id_jugador", $request->input('id_jugador'))->update(["puntajes_cartas" => $puntajeCartas[0]["puntajes_cartas"]+1]);

        if ($resul)
            return true;
        else
            return false;
    }

    function consultarCartas(){
        $carta = \App\reglas::all();


        return $carta;
    }

    function obtenerRegla($id_carta)
    {

        $reglas_x_juegos=\App\reglas_x_juegos::all();
        $reglas=\App\reglas::all();
        $cont=null;
       $regla=null;
       $aux=null;
        for($i=0;$i<count($reglas_x_juegos);$i++)
        {


            if($id_carta==$reglas_x_juegos[$i]->id_juego)
            {

                $cont=$reglas_x_juegos[$i]->id_reglas;

                for($j=0;$j<count($reglas);$j++)
                {
                    if($reglas[$j]->id==$cont)
                    {
                        $aux=$reglas[$j];
                    }
                }


            }


        }

        return $aux;
    }

    function desordenarCartas($cartas)
    {
        $aux=count($cartas)-1;
        $count=0;
        $arr[0]=null;
        while($count<=$aux)
        {
            $num1=rand(0,$aux);
            if(!in_array($num1,$arr))
            {
               $arr[$count]=$num1;
               $count++;
            }
        }
        return $arr;
    }


    function traerCartas()
    {
        $res = \App\cartas::all();
        return $res;

    }

    /*function ingresarRegla( Request $r)
    {

        $regla=$r->input('regla');
        $idCarta=$r->input('idCarta');
        ChullaVida::table('reglas')->insert( $regla );

        $idRegla=ChullaVida::table('reglas')->where ('descripcion',$regla);
        ChullaVida::table('reglas_x_juegos')->insert($idRegla,$idCarta);

    }
    function borrarRegla(Request $r)
    {
        $idRegla=$r->input('idRegla');
        ChullaVida::table('reglas')->where('id_reglas',$idRegla)->delete();
        ChullaVida::table('reglas_x_juegos')->where('id_reglas',$idRegla)->delete();

    }
    function editarRegla(Request $r)
    {
        $idRegla=$r->input('idRegla');
        $regla=$r->input('regla');
        ChullaVida::table('reglas')->where('id_reglas',$idRegla)->update('descripcion',$regla);
    }
    function verReglas()
    {
        $reglas=ChullaVida::table('reglas')->get();

        foreach($reglas as $row)
        {
            $id_Reglas[]=$row->id_Reglas;
            $descripcion[]=$row->descripcion;

        }
        return $descripcion();

    }*/



}
