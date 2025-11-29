use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // STEP 1 — Generate OTP dan pindah ke halaman OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Simpan email
        Session::put('reset_email', $request->email);

        // Generate OTP (4 digit)
        $otp = rand(1000, 9999);
        Session::put('otp', $otp);

        // Sementara tampilkan OTP di log (kalau mau kirim email juga bisa)
        \Log::info("OTP: " . $otp);

        return redirect()->route('otp');
    }

    // STEP 2 — Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        if ($request->otp != Session::get('otp')) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }

        // Jika benar → lanjut ke reset password
        return redirect()->route('password.reset');
    }

    // STEP 3 — Simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = Session::get('reset_email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session
        Session::forget('reset_email');
        Session::forget('otp');

        return redirect('/login-penjual')->with('success', 'Password berhasil direset');
    }
}
