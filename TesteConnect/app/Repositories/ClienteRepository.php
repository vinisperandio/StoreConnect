<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Cliente;

class ClienteRepository extends BaseRepository implements ClienteRepositoryInterface
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = Cliente::class;
        parent::__construct();
    }

    public function findEmail ($email)
    {
        return $this->model->where('Email', $email)->first();
    }
}