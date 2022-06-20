

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
   <script src="{{asset('web/js/jquery-3.6.0.min.js')}}"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="{{asset('web/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('web/js/popper.min.js')}}"></script>
    <script src="{{asset('web/js/slick.min.js')}}"></script>
    <script src="{{asset('web/js/fontawesome.js')}}"></script>
    <script src="{{asset('web/js/jstars.js')}}"></script>
    <script src="{{asset('web/js/jquery.star.rating.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
<!-- <script type="text/javascript">
$( document ).ready(function() {
      $.ajax({
         type : "get",
         dataType : "json",
         url : "{{route('get_year')}}",
         data: {_token: '1'},
         success: function(response) {
            if(response.status == 1) {
               $("#year_datalist").html(response.message)
            }
         }
      })   
      $('#year_datalist').on('change', function() {  
      year = $(this).val()
       if (year!='') {
      $.ajax({
         type : "get",
         dataType : "json",
         url : "{{route('get_make')}}",
         data: {year, year , _token:2},
         success: function(response) {
            if(response.status == 1) {
               $("#make_datalist").html(response.message)
            }
         }
      })   
}
   })
    });

    $("#year-search-side").on("input", function() {
        console.log($(this).val())
        var year = $(this).val();
        if (year!='') {
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: "{{route('get_make')}}",
                data: {year, year , _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 1) {
                        $("#make-side").html(response.message);
                    }
                }
            });
        }
    });
    $("#make-search-side").on("input", function() {
        console.log($(this).val())
        var make = $(this).val();
        var year = $("#year-search-side").val();
        console.log(year)
        if (make!='') {
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: "{{route('get_model')}}",
                data: {year:year,make: make , _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 1) {
                        $("#model-side").html(response.message);
                    }
                }
            });
        }
    });
</script> -->
<script type="text/javascript">
    $("#year_search").on("input", function() {
        console.log($(this).val())
        var year = $(this).val();
        
        if (year!='') {
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: "{{route('get_make')}}",
                data: {year, year , _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 1) {
                        $("#make_datalist").html(response.message);
                    }
                }
            });
        }
    });
    $("#make_search").on("input", function() {
        console.log($(this).val())
        var make = $(this).val();
        var year = $("#year_search").val();
        console.log(year)
        if (make!='') {
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: "{{route('get_model')}}",
                data: {year:year,make: make , _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 1) {
                        $("#model_datalist").html(response.message);
                    }
                }
            });
        }
    });



    $("#year-search-side").on("input", function() {
        console.log($(this).val())
        var year = $(this).val();
        if (year!='') {
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: "{{route('get_make')}}",
                data: {year, year , _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 1) {
                        $("#make-side").html(response.message);
                    }
                }
            });
        }
    });
    $("#make-search-side").on("input", function() {
        console.log($(this).val())
        var make = $(this).val();
        var year = $("#year-search-side").val();
        console.log(year)
        if (make!='') {
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: "{{route('get_model')}}",
                data: {year:year,make: make , _token: '{{csrf_token()}}'},
                success: function (response) {
                    if (response.status == 1) {
                        $("#model-side").html(response.message);
                    }
                }
            });
        }
    });
</script>
<script src="{{asset('web/js/custom.js')}}"></script>
<script>
  

  // $(document).ready(function(){
  //   var description = CKEDITOR.replace( 'description' );
  //   description.on( 'change', function( evt ) {
  //       $("#description").text( evt.editor.getData())    
  //   });
  // })
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true,
    "debug": false,
    "positionClass": "toast-bottom-right",
  }
        toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true,
    "debug": false,
    "positionClass": "toast-bottom-right",
  }
        toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true,
    "debug": false,
    "positionClass": "toast-bottom-right",
  }
        toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true,
    "debug": false,
    "positionClass": "toast-bottom-right",
  }
        toastr.warning("{{ session('warning') }}");
  @endif
</script>
    