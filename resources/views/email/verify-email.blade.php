<x-guest-layout>
    <h1>Xác minh địa chỉ email</h1>

    <p>Vui lòng kiểm tra email để xác minh tài khoản.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Link xác minh đã được gửi lại!
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Gửi lại email xác minh</button>
    </form>
</x-guest-layout>
