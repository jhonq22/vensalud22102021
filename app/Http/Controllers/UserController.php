<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{   



      public function index()
    {
        //$users = User::get();
        //echo json_encode($users);


        $users = DB::select("
            SELECT users.id, name, email, users.created_at, users.updated_at, ente
            FROM users
            LEFT JOIN entes ON ente_id = entes.id");
        echo json_encode($users); // para pasar en json


    }


    public function totalUsuarios()
    {
        $usuario_total = DB::select("SELECT COUNT(*) as usuarios
                                   FROM users");
        echo json_encode($usuario_total); // para pasar en json

    }





  public function store(Request $request)
    {

        $fileName = time().'int.png';
        $path = $request->file('image')->move(public_path("/uploads"), $fileName);
        $photoURL = url('/uploads/usuarios/'. $fileName);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->json()->get('password'));
        $user->ente_id = $request->input('ente_id');
        $user->image = $photoURL;
        $user->nombre_img = $fileName;
        $token = JWTAuth::fromUser($user);
        //return response()->json(compact('user','token'),201);
        $user->save();
        echo json_encode($user); // para pasar en json
       

        //$user->save(); // para guardar en json

        //echo json_encode($user); // para pasar en json
    }

   

    public function show($user_id)
    {
        $users = User::find($user_id);
        echo json_encode($users);
    }
    
   
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
       $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->json()->get('password'));
        $user->ente_id = $request->input('ente_id');
        $user->centro_salud_id = $request->input('centro_salud_id');
        $user->estado_id = $request->input('estado_id');
        $user->rol_id = $request->input('rol_id');
      
        $user->save(); // para guardar en json

        echo json_encode($user); // para pasar en json
    }









  
    public function destroy($user_id)
    {
        $user = User::find($user_id);
        $user->delete();
    }








    public function register(Request $request)
    {
            $validator = Validator::make($request->json()->all() , [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string', 
           
        ]);
        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }



        $user = User::create([
            'name' => $request->json()->get('name'),
            'email' => $request->json()->get('email'),
            'ente_id' => $request->json()->get('ente_id'),
            'rol_id' => $request->json()->get('rol_id'),
            'centro_salud_id' => $request->json()->get('centro_salud_id'),
            'estado_id' => $request->json()->get('estado_id'),
            'password' => Hash::make($request->json()->get('password')),
        ]);



        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }



    
    public function login(Request $request)
    {
        $credentials = $request->json()->all();
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json( compact('token') );
    }
    
    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }
}