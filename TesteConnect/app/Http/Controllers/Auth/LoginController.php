<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Repositories\ClienteRepository;
use App\Pessoa;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $clienteRepository;
    private $token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository();
        $this->middleware('guest')->except('logout');
        // Unique Token
        $this->token = uniqid(base64_encode(Str::random(60)));
    }

    /**
     * Authenticate user.
     *
     * @param Request Request instance
     *
     * @return JSON user details and auth credentials
     */
    public function postLogin(Request $request)
    {
      // Validations
      $rules = [
        'email'=>'required',
        'senha'=>'required|min:5'
      ];

      $message = [
        'email.required' => "Informe um Email",
        'senha.required' => "Informe uma Senha",
      ];

      $validator = Validator::make($request->all(), $rules, $message);
      if ($validator->fails()) {
        // Validation failed
        return response()->json([
          'error' => true,
          'message' => $validator->errors()->all(),
          'status' => 422
        ]);
      }

      // Fetch User
      $user = $this->clienteRepository->findEmail($request['email']);
      if ($user) {
        return response()->json([
          'error' => false,
          'user' => [
            'Nome' => $user->Nome,
            'CodPessoa' => $user->Id,
            'Email' => $user->Email,
            'DataCadastro' => $user->DataCadastro,
            'access_token' => $this->token,
          ]
        ]);
      } else {
        return response()->json([
          'error' => true ,
          'message' => ['Usuário não encontrado']
        ], 200);
      }
    }
}
