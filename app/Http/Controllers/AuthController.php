<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    
    //  register
    public function register(Request $request)
{
    $validateData= Validator::make($request->all(),[
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|confirmed|min:8|',
        // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

    ]);
      if ($validateData->fails()) {
        return response()->json(['error' => $validateData->errors()], 400);
    }
    // $nama_gambar = null;
    // if ($request->hasFile('image')) {
    //     $gambar = $request->file('image');
    //     $nama_gambar = time().'.'.$gambar->extension();
    //     $gambar->move(public_path('images'), $nama_gambar);
    // } else {
    //     // Set gambar default jika tidak ada gambar yang diunggah
    //     $nama_gambar = 'default.png';
    // }
    // $validateData["password"] = Hash::make($request->password);
$validator = $validateData->valid();

    $user = User::create([
        'name' => $validator['name'],
        'email' => $validator['email'],
        'password' => bcrypt($validator['password']),
        // 'image' => $nama_gambar,
    ]);

       $token = $user->createToken('API Token')->accessToken;

        return response()->json(['user' => $user,'token' => $token], 201);

        
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     
     */
    //  login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $token,'user' => $user, 'message' => 'Succesfully login'], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    // logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }
    // informasi user
    public function userApi()
{
    // Mendapatkan pengguna yang terotentikasi
    $user = Auth::user();

    // Mengakses informasi pengguna
    $userId = $user->id;
    $name = $user->name;
    $email = $user->email; 
    // $imageUrl = url('images/' . $user->image);
    $role = $user->role; 
    $password = $user->password; 

    // Lakukan operasi lain dengan informasi pengguna

    // Mengembalikan respons
    return response()->json(['user_id' => $userId, 'name' => $name, 'email' => $email, 'role' => $role, 'password' => $password]);
}

// update 
   public function update(Request $request)
    {
        
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|confirmed|min:8',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|in:user,admin'
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // if ($request->hasFile('image')) {
        //     // Jika ada gambar yang diberikan, simpan gambar yang diberikan
        //     $imagePath = $request->file('image')->store('public/images');
        //     $data['image'] = $imagePath;
        // } else {
        //     // Jika tidak ada gambar yang diberikan, set gambar default
        //     $data['image'] = 'default.png';
        // }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully' ,'user'=> $user]);
    }
    // forget password
     public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], Response::HTTP_NOT_FOUND);
        }

        $newPassword = $this->generateRandomPassword();
        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Password reset successful.', 'new_password' => $newPassword]);
    }
    // generate random password
    private function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }
}
