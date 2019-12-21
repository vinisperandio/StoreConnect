<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Strings;
use Exception;

class Transations extends BaseRepository implements TransationsInterface
{
    protected $modelClass;
    
    public static function SalvarDeletarComTransaction ($entity, $delete = []) {
        
        try{
            DB::transaction(function () use ($entity, $delete) {
                for ($i=0; $i < sizeof($delete) ; $i++) {
                    $delete[$i]->delete();
                }
                for ($i=0; $i < sizeof($entity) ; $i++) {
                    $entity[$i]->save();
                }
            });
            return $entity;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}