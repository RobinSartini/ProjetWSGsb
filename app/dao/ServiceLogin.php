<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 29/01/2019
 * Time: 14:23
 */

namespace App\dao;

use App\Exceptions\MonException;
use App\metier\Visiteur;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use DB;
use App\metier\Frais;
use App\metier\Etat;

class ServiceLogin
{
    /**
     * Vérifie le login et mdp visiteur
     * @param type $json
     * @return \Visitor
     * @throws Exception
     */
    public function getConnexion($login_visiteur,$pwd_visiteur)
    {
        $visiteur=null;
        if ($login_visiteur != null) {
            try {
                $visiteur = DB::table('visiteur')
                    ->where('login_visiteur',[$login_visiteur])
                    ->first();
                if ($visiteur != null) {
                    if (Hash::check($pwd_visiteur, $visiteur->pwd_visiteur)) {
                        $response = $visiteur;
                    } else
                    $response =null;
                } else
                    $response = null;

            } catch (QueryException $e) {
                throw new MonException($e->getMessage());
            }
        }
        return $response;
    }


    //SELECT BY ID d'un visiteur
    public function getById($id)
    {
        try {
            $visiteur = DB::table('visiteur')
                ->where('id_visiteur', '=', $id)
                ->first();
            $response = array(
                'status' => 1,
                'status_message' => "Identification correcte",
                'data' => $visiteur
            );
            return $response;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage());
        }
    }

    public function miseAjourMotPasse($pwd) {
        try {
            DB::table('visiteur')
                ->update(['password' => $pwd,]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage());
        }
    }
}
