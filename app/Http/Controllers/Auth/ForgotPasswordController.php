<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form forgot password
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Cek email di database
     */
    public function checkEmail(Request $request)
    {
        try {
            // Validasi: hanya email yang diterima
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255'
            ], [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $email = $request->email;

            // Cari user berdasarkan email saja
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar dalam sistem kami.'
                ], 404);
            }

            // Simpan email di session untuk validasi step berikutnya
            session([
                'reset_email' => $email,
                'reset_user_id' => $user->id,
                'reset_time' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email ditemukan! Silakan buat password baru.',
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_name' => $user->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'email' => 'required|email',
                'new_password' => 'required|min:8|confirmed'
            ], [
                'new_password.min' => 'Password minimal 8 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Validasi session untuk keamanan
            $sessionEmail = session('reset_email');
            $sessionUserId = session('reset_user_id');
            $resetTime = session('reset_time');

            // Cek apakah session valid (15 menit)
            if (!$resetTime || now()->diffInMinutes($resetTime) > 15) {
                session()->forget(['reset_email', 'reset_user_id', 'reset_time']);
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi telah berakhir. Silakan mulai ulang.'
                ], 403);
            }

            // Cek konsistensi data
            if ($sessionEmail !== $request->email || $sessionUserId != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan tidak valid. Silakan mulai ulang.'
                ], 403);
            }

            // Update password
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.'
                ], 404);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            // Hapus session
            session()->forget(['reset_email', 'reset_user_id', 'reset_time']);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset! Anda dapat login dengan password baru.',
                'redirect_url' => route('login')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset password. Silakan coba lagi.'
            ], 500);
        }
    }
}
