<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function register_user(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users,email', // Campo obrigatório, formato de email válido e único na tabela users
            'password' => 'required|min:6', // Campo obrigatório e com no mínimo 6 caracteres
            'name' => 'required', // Campo obrigatório
        ];

        // Mensagens personalizadas de erro
        $messages = [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email informado não é válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'name.required' => 'O campo senha é obrigatório.',
        ];

        // Executar a validação
        $validator = Validator::make($request->all(), $rules, $messages);

        // Verificar se a validação falhou
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors() // Retornar os erros de validação
            ], 422); // Código HTTP 422 - Unprocessable Entity
        }


        try {
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = Hash::make($request->password); // Criptografar a senha antes de salvar           
            $user->save();

            // Gerar o access token inicial
            $accessToken = JWTAuth::fromUser($user);



            // Gerar o refresh token a partir do token inicial
            JWTAuth::setToken($accessToken); // Define o token inicial como ativo
            $refreshToken = JWTAuth::refresh();
            $user_up = User::find($user->id);

            $user_up->refresh_token = $refreshToken;
            $user_up->save();

            return response()->json([
                'message' => 'Usuário registrado com sucesso!',
                'user' => $user,
                'acess_token' => $accessToken,
                '$refreshToken' => $refreshToken,
                'user_id' => $user->id,
                'user_update' => $user_up
            ], 201); // Código HTTP 201 - Created
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao registrar o usuário.',
                'details' => $e->getMessage()
            ], 500); // Código HTTP 500 - Internal Server Error
        }
    }

    public function login(Request $request)
    {

        $credentials = $request->all(['email', 'password']);

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Credenciais invalidadas'], 401);
            }

            // Get the authenticated user.
            $user = auth('api')->user();

            // (optional) Attach the role to the token.
            // o role é a coluna da tabela users , para definir se é um adim ou usiario normal; // e role é adicionado ao payload do token ;
            // o from user é utilizado para gear o token e incluir informaçãos do usario ao token;
            // claims é para adioncar valores personalizado no paylod do token; 
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);
            $token2 = JWTAuth::fromUser($user);  // gera um token a partir do usuario recebido no request;


            //  TesteEvent::dispatch($user->id); 
            // $ret = event(new TesteEvent($user['id']));

            // $ret = event(new TesteEvent($user['id']));
            // $ret2 = TesteEvent::dispatch("We've got a new announcement!");;

            return response()->json([

                "token" => $token,
                "user_role" => $user->role,
                "token2" => $token2,
                "user" => $user,
                // "ret" => $ret,
                // "ret2" => $ret2,


            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function logout()
    { {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Successfully logged out', 'status' => 200], 200);
        }
    }
    public function checkToken(Request $request)
    {
        return 'ola';
    }

    public function refresh_token()
    {

        //   $user = auth('api')->user();   
        $tk = JWTAuth::getToken();

        $success = $this->respondWithToken(JWTAuth::parseToken()->refresh($tk));
        return $this->sendResponse($success, 'Refresh token return successfully.');
    }

    // para usar caso a primeira op~çao não funcione;
    public function refresh_new($tk)
    {

        //   $user = auth('api')->user();   
        $tk = JWTAuth::getToken();

        $success = $this->respondWithToken(JWTAuth::parseToken()->refresh($tk));
        return $this->sendResponse($success, 'Refresh token return successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
