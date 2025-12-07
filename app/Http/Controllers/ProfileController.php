<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('profile.index', compact('user'));
    }

    /**
     * Update profil user
     */
    public function update(Request $request)
    {
        try {
            // Dapatkan user dari database langsung
            $user = User::find(Auth::id());

            if (!$user) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User tidak ditemukan. Silakan login kembali.'
                    ], 401);
                }
                return redirect()->route('login')->with('error', 'User tidak ditemukan. Silakan login kembali.');
            }

            Log::info('Profile update request for user ID: ' . $user->id);

            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_photo' => 'nullable|boolean',
                'current_password' => 'nullable|required_with:new_password',
                'new_password' => 'nullable|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed: ' . json_encode($validator->errors()->all()));

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            // Update data dasar
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->address = $request->address ?? $user->address;

            // Handle upload foto profil
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama jika ada
                if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                    Storage::delete('public/profile-photos/' . $user->profile_photo);
                }

                // Upload foto baru
                $file = $request->file('profile_photo');
                $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Simpan file
                $file->storeAs('public/profile-photos', $fileName);

                // Update nama file di database
                $user->profile_photo = $fileName;
            }

            // Handle hapus foto jika checkbox dicentang
            if ($request->has('remove_photo') && $request->remove_photo == '1') {
                if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                    Storage::delete('public/profile-photos/' . $user->profile_photo);
                }
                $user->profile_photo = null;
            }

            // Update password jika diisi
            if ($request->filled('current_password') && $request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    Log::error('Current password mismatch for user ID: ' . $user->id);

                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Password saat ini salah.'
                        ], 422);
                    }
                    return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
                }

                $user->password = Hash::make($request->new_password);
            }

            // Simpan perubahan - gunakan save() dengan exception handling
            try {
                $user->save();
                Log::info('Profile updated successfully for user ID: ' . $user->id);
            } catch (\Exception $e) {
                Log::error('Failed to save user: ' . $e->getMessage());
                throw new \Exception('Gagal menyimpan perubahan ke database: ' . $e->getMessage());
            }

            // Jika request AJAX (upload foto saja)
            if ($request->ajax() || $request->wantsJson()) {
                // Get full URL untuk foto profil
                $avatarUrl = $user->profile_photo ?
                    asset('storage/profile-photos/' . $user->profile_photo) . '?t=' . time() :
                    $this->getDefaultAvatarUrl($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile berhasil diperbarui',
                    'avatar_url' => $avatarUrl,
                    'profile_photo' => $user->profile_photo,
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'address' => $user->address
                    ]
                ]);
            }

            return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Hapus foto profil (API endpoint)
     */
    public function deletePhoto(Request $request)
    {
        try {
            // Dapatkan user dari database langsung
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 401);
            }

            Log::info('Delete photo request for user ID: ' . $user->id);

            // Hapus file dari storage
            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
            }

            // Update database - set profile_photo ke null
            $user->profile_photo = null;
            $user->save();

            Log::info('Profile photo deleted successfully for user ID: ' . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus',
                'avatar_url' => $this->getDefaultAvatarUrl($user)
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting profile photo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get default avatar URL
     */
    private function getDefaultAvatarUrl($user)
    {
        $initial = strtoupper(substr($user->name, 0, 1));
        $colors = ['#3F2305', '#6E3F0C', '#2A1703', '#FF9F1C', '#FF4757'];
        $color = $colors[ord($initial) % count($colors)];

        return "https://ui-avatars.com/api/?name=" . urlencode($user->name) .
            "&color=FFFFFF&background=" . substr($color, 1) .
            "&size=200&bold=true&font-size=0.8";
    }

    /**
     * Menampilkan order user
     */
    public function orders()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orders = collect();
        return view('profile.orders', compact('orders'));
    }
}
