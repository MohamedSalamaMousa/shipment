<!DOCTYPE html>
<html lang="ar" dir="rtl">

@include('layouts.head')

<body class="min-vh-100 bg-light">
    @include('layouts.nav')

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            const loginBtn = document.getElementById("show-login-form");
            const loginForm = document.getElementById("login-form");

            if (loginBtn === null || loginForm === null) {
                return
            }
            loginBtn.addEventListener("click", function(e) {
                e.preventDefault(); // prevent page jump
                loginForm.classList.toggle("show");
            });

            // Close when clicking outside
            document.addEventListener("click", function(e) {
                const isClickInside =
                    loginForm.contains(e.target) || loginBtn.contains(e.target);
                if (!isClickInside) {
                    loginForm.classList.remove("show");
                }
            });
        });
    </script>

    @include('layouts.footer')
</body>

</html>
