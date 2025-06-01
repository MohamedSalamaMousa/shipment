<style>
    footer a:hover {
        color: #fff !important;
        text-decoration: underline;
    }
</style>


<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container text-md-start">
        <div class="row justify-content-between">

            <!-- Logo & Description -->
            <div class="col-md-4 col-lg-4 col-xl-3 mb-4">
                <h5 class="text-uppercase fw-bold text-danger mb-3">تيــتكس</h5>
                <p>
                    شركة تيتكس محلية ودولية، تعامل بريدي (تعاقد رقم 9546)، وتعامل حكومي بريدي كامل.<br>
                    نقدم خدمات موثوقة وسريعة لتوصيل شحناتك إلى أي مكان داخل وخارج جمهورية مصر العربية.
                </p>
            </div>

            <!-- Useful Links -->
            <div class="col-md-4 col-lg-3 col-xl-2 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">روابط سريعة</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about') }}" class="text-white-50 text-decoration-none d-block mb-2">من نحن</a>
                    <li><a href="{{ route('contact') }}" class="text-white-50 text-decoration-none d-block mb-2">تواصل
                            معنا</a>
                    </li>
                    <li><a href="{{ route('terms') }}" class="text-white-50 text-decoration-none d-block mb-2">الشروط
                            والأحكام</a>
                    </li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-md-4 col-lg-3 col-xl-3 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">تابعنا</h6>
                <a id="facebookLink" href="#" target="_blank" class="text-white-50 me-3"><i
                        class="fab fa-facebook fa-lg"></i></a>
                <a id="instagramLink" href="#" target="_blank" class="text-white-50 me-3"><i
                        class="fab fa-instagram fa-lg"></i></a>
               
            </div>

        </div>

        <!-- Divider -->
        <hr class="text-white-50" />

        <!-- Bottom -->
        <div class="text-center small text-white-50">
            © {{ date('Y') }} Tetex Express. جميع الحقوق محفوظة.
        </div>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://admin.tetexexpress.com/api/socailMedia')
            .then(response => response.json())
            .then(data => {
                const social = data[0]; // أول عنصر في النتائج

                // تحديث الروابط إذا وُجدت
                if (social.facebook) {
                    document.getElementById('facebookLink').href = social.facebook;
                } else {
                    document.getElementById('facebookLink').style.display = 'none';
                }

                if (social.instagram) {
                    document.getElementById('instagramLink').href = social.instagram;
                } else {
                    document.getElementById('instagramLink').style.display = 'none';
                }


            })
            .catch(error => {
                console.error('فشل في جلب بيانات وسائل التواصل:', error);
            });
    });
</script>
