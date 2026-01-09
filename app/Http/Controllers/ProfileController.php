<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user + order history (1 halaman)
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil orders dari DB (authoritative)
        // Eager load items agar view bisa render daftar item
        $orders = Order::query()
            ->where('user_id', $user->id)
            ->with(['items']) // pastikan relasi Order->items() ada
            ->orderByDesc('created_at')
            ->get();

        $recentOrders = $orders->take(3);
        $ordersCount = $orders->count();

        return view('profile.index', compact('user', 'orders', 'recentOrders', 'ordersCount'));
    }

    /**
     * Update profil user
     */
    public function update(Request $request)
    {
        try {
            $user = User::find(Auth::id());

            if (!$user) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User tidak ditemukan. Silakan login kembali.'
                    ], 401);
                }
                return redirect()->route('login')->with('error', 'User tidak ditemukan. Silakan login kembali.');
            }

            Log::info('Profile update request for user ID: ' . $user->id);

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

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            // Update basic fields
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->address = $request->address ?? $user->address;

            // Handle upload
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                    Storage::delete('public/profile-photos/' . $user->profile_photo);
                }

                $file = $request->file('profile_photo');
                $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profile-photos', $fileName);
                $user->profile_photo = $fileName;
            }

            // Remove photo if requested
            if ($request->has('remove_photo') && $request->remove_photo == '1') {
                if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                    Storage::delete('public/profile-photos/' . $user->profile_photo);
                }
                $user->profile_photo = null;
            }

            // Update password if provided
            if ($request->filled('current_password') && $request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Password saat ini salah.'
                        ], 422);
                    }
                    return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
                }
                $user->password = Hash::make($request->new_password);
            }

            $user->save();
            Log::info('Profile updated successfully for user ID: ' . $user->id);

            // JSON response for AJAX
            if ($request->ajax() || $request->wantsJson()) {
                $avatarUrl = $user->profile_photo
                    ? asset('storage/profile-photos/' . $user->profile_photo)
                    : $this->getDefaultAvatarUrl($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile berhasil diperbarui',
                    'avatar_url' => $avatarUrl,
                    'profile_photo' => $user->profile_photo,
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'address' => $user->address,
                    ]
                ]);
            }

            return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
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
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 401);
            }

            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
            }

            $user->profile_photo = null;
            $user->save();

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
     * Route order history -> tetap ada, tapi 1 halaman
     */
    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // tetap 1 view: pindah ke tab orders
        return redirect()->route('profile') . '#tab-orders';
    }

    /**
     * Get default avatar URL
     */
    private function getDefaultAvatarUrl($user)
    {
        $initial = strtoupper(substr($user->name, 0, 1));
        $colors = ['#4E1F00', '#74512D', '#FEBA17'];
        $color = $colors[ord($initial) % count($colors)];

        return "https://ui-avatars.com/api/?name=" . urlencode($user->name) .
            "&color=FFFFFF&background=" . substr($color, 1) .
            "&size=200&bold=true&font-size=0.8";
    }
}
