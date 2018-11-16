<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cartasDP extends Controller
{


    function cascada()
    {
        $jugdores=$jugadores = Array('data'=>\App\jugador::all());;
        $num=count($jugdores);
        $cartasJugador=array(array());

        $cartas=$this->traerCartas();
        $count=0;
        $count2=0;
        $cartasDesordenadas=$this->desordenarCartas($cartas);

        $reglas=array();
        for($i=0;$i<count($cartasDesordenadas);$i++)
        {
             if($count=$num-1)
             {
                 $count=0;
                 $count2++;
             }

             $cartasJugador[$count][$count2]=$cartasDesordenadas[$i];

             $reglas[$i]=obtenerRegla($cartasDesordenadas[$i][0]);
             $count++;
        }
        $reglas  = json_encode($reglas);
        return $reglas;
    }

    function obtenerRegla($id_carta)
    {

        $registro=ChullaVida::table('reglas_x_juegos')->where('id_juego',$id_carta);
        $regla=ChullaVida::table('reglas')->where('id_reglas',$registro[0]);
        return $regla[1];
    }

    function desordenarCartas($cartas)
    {

        $indice=0;
        $aux[]=null;
        $count=0;
        while($count<count($cartas[$indice]))
        {
            $num1=rand($indice,count($cartas[$indice])-1);
            if(!in_array($num1,$aux))
            {

                $aux[$count]=$num1;
                $arr[$count]=$cartas[$num1];
                $count++;
            }
        }
        return $arr;
    }


    function traerCartas()
    {
        $cartas=Array('data1'=>\App\cartas::all());;
        foreach($cartas as $row)
        {
            $id_cartas[]=$row->id_cartas;
            $numero[]=$row->numero;
            $palo[]=$row->palo;
            $imagen[]=$row->imagen ;

        }

        $arr=array('id_cartas'=>$id_cartas,'numero'=>$numero,'palo'=>$palo,'imagen'=>$imagen);
        return $arr;

    }

    function ingresarRegla( Request $r)
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

    }
    function consultarCartas(){
        $carta = Array('data'=>\App\cartas::all());
        /*foreach ($jugadores as $row)
        {
            $nombre = $row->nombre;
            $apellido = $row->apellido;
            $apodo = $row->apodo;
            $fechaNac = $row->fechaNac;

            $arr = array("nombre"=> $nombre,"apellido"=>$apellido,
                "apodo"=>$apodo, 'fechaNac'=> $fechaNac);
            $resultado[] = $arr;
        }*/
        $resultado = json_encode($carta);
        return $resultado;
    }


}
