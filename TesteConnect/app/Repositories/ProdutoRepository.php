<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Produto;

class ProdutoRepository extends BaseRepository implements ProdutoRepositoryInterface
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = Produto::class;
        parent::__construct();
    }
}