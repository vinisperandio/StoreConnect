<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'Auth\LoginController@postLogin');

Route::middleware('APIToken')->get('/cliente', 'ClienteController@get');
Route::post('/cliente/save', 'ClienteController@save');
Route::middleware('APIToken')->put('/cliente/update', 'ClienteController@update');
Route::middleware('APIToken')->delete('/cliente/delete', 'ClienteController@delete');

Route::middleware('APIToken')->get('/produto', 'ProdutoController@get');
Route::middleware('APIToken')->post('/produto/save', 'ProdutoController@save');
Route::middleware('APIToken')->put('/produto/update', 'ProdutoController@update');
Route::middleware('APIToken')->delete('/produto/delete', 'ProdutoController@delete');

//todos os pedidos de um cliente
Route::middleware('APIToken')->get('/pedidos', 'PedidoController@get');
//todos os itens de um pedido
Route::middleware('APIToken')->get('/itens', 'ItemPedidoController@get');
//realiza a compra
Route::middleware('APIToken')->post('/carrinho/buy', 'PedidoController@buy');