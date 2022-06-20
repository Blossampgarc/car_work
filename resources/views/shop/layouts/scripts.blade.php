<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{asset('web/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('web/js/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/popper.min.js')}}"></script>
<script src="{{asset('web/js/slick.min.js')}}"></script>
<script src="{{asset('web/js/fontawesome.js')}}"></script>
<script src="{{asset('web/js/custom.js')}}"></script>
<script src="{{asset('web/js/intlTelInput.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript:"js/utils.js",
        });
    </script>
    <!-- <script type="text/javascript">
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demoo");
        output.innerHTML = slider.value;
        slider.oninput = function() {
            output.innerHTML = this.value;
        }
    </script> -->
    <script type="text/javascript">
        $('.hdr-menu').on('mouseover', ' li', function() {
            $('.hdr-menu li.active').removeClass('active');
            $(this).addClass('active');
        });
    </script>
    <script src="js/slick.min.js"></script>
    <script type="text/javascript">
    $('.card-deck a').fancybox({
            caption : function( instance, item ) {
                return $(this).parent().find('.card-text').html();
            }
        });
</script>

    <script>

        jQuery(document).ready(function ($) {
            $('.laptop-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
                arrows: false,
                speed: 1000,
                touchMove: false,
                responsive: [{
                    breakpoint: 769,
                    settings: {
                        arrows: false,
                        dots: true,
                        touchMove: true
                    }
                }]
            });


            $(document).on("click", ".smallnav img", function () {
                var di = $(this).data("index");
                $('.laptop-slider').slick('slickGoTo', di);

            });


        });




    </script>
<script>
  AOS.init();
</script>


@yield('script')


