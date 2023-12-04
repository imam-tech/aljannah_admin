<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\User;
use App\Models\UserParent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository {
    public function login($data) {
        try {
            $user = User::with(['role.rolePermissions.permission'])->where('email', $data['email'])->first();
            if (!$user) return resultFunction("Err code AR-L: user " . $data['email'] . ' is not found');

            if (!Hash::check($data['password'], $user['password'])) {
                return resultFunction("Err code AR-L: password of user " . $data['email'] . ' is not correct');
            }


            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;

            return resultFunction("", true, [
                "user" => $user,
                "token" => $token
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-L: catch " . $e->getMessage());
        }
    }

    public function logout($request) {
        try {
            $request->user()->currentAccessToken()->delete();
            return resultFunction("Success logged out", true);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-LOg: catch " . $e->getMessage());
        }
    }

    public function loginParent($data) {
        try {
            $student = Student::with(['user_parent'])->where('nomor_induk_siswa', $data['code'])->first();
            if (!$student) return resultFunction("Err code AR-L: data tidak ditemukan");

            if (!$student->user_parent) return resultFunction("Err code AR-L: data tidak ditemukan");

            if (!Hash::check($data['password'], $student->user_parent->kata_sandi)) {
                return resultFunction("Err code AR-L: Kata sandi untk kode siswa " . $data['code'] . ' tidak benar');
            }
            $userParent = $student->user_parent;

            $token = $userParent->createToken('API Token')->plainTextToken;

            return resultFunction("", true, [
                "user" => $userParent,
                "token" => $token
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code AR-L: catch " . $e->getMessage());
        }
    }
}