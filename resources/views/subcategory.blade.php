@extends('layouts.main') 
@section('content')
<!-- START: Main Content-->
<main>
    <div class="container-fluid site-width" id="mypitch">
        <!-- START: Card Data-->
        

        <!-- Add Event Modal -->
        
        <div id="addevent" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg text-left">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="model-header">Form</h4>
                    </div>
                    <div class="modal-body">

                        <form class="" id="generic-form" enctype="multipart/form-data" method="POST" action="{{route('crud_generator', 'subcategory')}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <input type="hidden" name="record_id" id="record_id" value="" />
                            <input type="hidden" name="accessories_id" id="accessories_id" value="{{$accessories_id}}" />
                            <input type="hidden" name="category_id" id="category_id" value="{{$category_id}}" />
                            <div class="row">

                                <div id="assignrole"></div>
                                <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                                    <div class="form-group start-date">
                                        <label for="start-date" class="">Banner Image:</label>
                                        <div class="d-flex">
                                            <input type="file" id="banner" accept="image/*" name="banner" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                                    <div class="form-group start-date">
                                        <div class="d-flex">
                                            <td><img id="banner-add" style="width:180px;height:60px;display:none;" src=""></td>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                                    <div class="form-group start-date">
                                        <label for="start-date" class="">Title:</label>
                                        <div class="d-flex">
                                            <input id="name" placeholder="Title" name="name" class="form-control" type="text" autocomplete="off" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                                    <div class="form-group start-date">
                                        <label for="start-date" class="">Image:</label>
                                        <div class="d-flex">
                                            <input type="file" id="image" accept="image/*" name="image" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                                </div>
                                <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                                    <div class="form-group start-date">
                                        <div class="d-flex">
                                            <td><img id="image-add" style="width:80px;height:80px;display:none;" src=""></td>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                                    <div class="form-group start-date">
                                        <label for="start-date" class="">Detail:</label>
                                        <div class="d-flex">
                                            <input id="detail" placeholder="Detail" name="detail" class="form-control" type="text" autocomplete="off" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-6 col-12" id="role-label">
                                    <div class="form-group end-date">
                                        <label for="end-date" class="">Description:</label>
                                        <div class="d-flex">
                                            <textarea id="desc" name="desc" class="form-control" placeholder="Description" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-6 col-12" id="role-label">
                                    <div class="form-group end-date">
                                        <label for="end-date" class="">Key Words:</label>
                                        <div class="d-flex">
                                            <textarea id="keyword" name="keyword" class="form-control" placeholder="Key Words" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        
                    </div>
                    
                    <div class="modal-footer">
                        
                        <button id="discard" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                        <button id="add-generic" type="submit" class="btn btn-primary eventbutton">Create</button>
                        
                    </div>
                </div>
            </div>
        </div>
            
            

        <h3>Subcategory</h3>
        <div class="row">

            <div class="col-12 col-md-6 col-lg-3 mt-3 updateevent"  style="cursor: pointer;">
                <div class="card border-bottom-0">
                    <div class="card-content border-bottom border-primary border-w-5" style="border-color: #b3ff00 !important;">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="circle-50 outline-badge-primary" style="color: #b3ff00;border: 1px solid #b3ff00;"><span class="cf card-liner-icon cf-xsn mt-2"></span></div>
                                <div class="media-body align-self-center pl-3">
                                    <span class="mb-0 h6 font-w-600">Subcategory</span> <br/>
                                    <p class="mb-0 font-w-500 h6">Subcategory </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
             <div class="col-12 mt-3">
                <div class="card">
                   <div class="card-header justify-content-between align-items-center">
                      <h4 class="card-title">Subcategory Report</h4>
                   </div>
                   <div class="card-body">
                      <div class="table-responsive">

                        <?php
                        $data = 'App\Models\subcategory';
                        $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->where('category_id',$category_id)->get();
                        $category = App\Models\category::where('is_active',1)->where('is_deleted',0)->where('id',$category_id)->first();
                        $accessory = App\Models\accessories::where('is_active',1)->where('is_deleted',0)->where('id',$accessories_id)->first();
                        ?>
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Accessory</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Detail</th>
                                    <th>Image</th>
                                    <th>Key Word</th>
                                    <th>Description</th>
                                    <th>Banner</th>
                                    <th>Creation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($loop)
                                @foreach($loop as $key => $val)
                                <?php 
                                $i = $i=asset($val->image);
                                $bann=asset($val->banner);
                                ?>
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$accessory->name}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->detail}}</td>
                                    <td><img style="width: 80px; height: 80px;" src="{{$i}}" /></td>
                                    <td>{{$val->keyword}}</td>
                                    <td>{{$val->desc}}</td>
                                    <td><img style="width:180px;height:60px;" src="{{$bann}}"></td>
                                    <td><?php echo date("M d,Y" ,strtotime($val->created_at)); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary editor-form" data-edit_id= "{{$val->id}}" data-accessories_id="{{$accessory->id}}" data-category_id="{{$category->id}}" data-name="{{$val->name}}" data-detail="{{$val->detail}}" data-image="{{$i}}" data-keyword="{{$val->keyword}}" data-desc="{{$val->desc}}" data-banner="{{$bann}}">Edit</button>
                                        <button type="button" class="btn btn-danger delete-record" data-model="App\Models\subcategory" data-id= "{{$val->id}}" >Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S. No</th>
                                    <th>Accessory</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Detail</th>
                                    <th>Image</th>
                                    <th>Key Word</th>
                                    <th>Description</th>
                                    <th>Banner</th>
                                    <th>Creation Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>

                        </table>
                        
                      </div>
                   </div>
                </div>
            </div>
        </div>
        
        <!-- END: Card DATA-->
    </div>
</main>
<!-- END: Content-->

@endsection 
@section('css') 
<link rel="stylesheet" href="{{asset('vendors/datatable/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('vendors/datatable/buttons/css/buttons.bootstrap4.min.css')}}"/>
@endsection 
@section('js')
<script src="{{asset('vendors/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script src="{{asset('js/datatable.script.js')}}"></script>
<script type="text/javascript">







    
</script>
<script id="scriptor" type="text/javascript">
    
</script>
<script type="text/javascript">
    $("body").on("click" ,".editor-form",function(){
        $("#name").val($(this).data("name"))
        $("#detail").val($(this).data("detail"))
        $("#keyword").val($(this).data("keyword"))
        $("#desc").val($(this).data("desc"))
        $("#accessories_id").val($(this).data("accessories_id"))
        $("#category_id").val($(this).data("category_id"))
        $("#record_id").val($(this).data("edit_id"))
        $("#image").removeAttr("required");
        $("#image-add").css("display","");
        $("#image-add").attr("src",$(this).data("image"));
        $("#banner").removeAttr("required");
        $("#banner-add").css("display","");
        $("#banner-add").attr("src",$(this).data("banner"));
        $("#addevent").modal("show")
    })




    $("#add-generic").click(function(f){
        var has_error = 0
        $("#generic-form select,textarea,input").each(function(i,e){
            if($(e).prop("required") == true){
                if($(e).val() == ""){
                    has_error++;
                    f.preventDefault();
                    console.log("done")
                    return false
                }
            }
        })
        if(has_error == 0){
            console.log("no error")
            $("#generic-form").submit();
        } else{
            toastr.error("Fill all required fields");
        }
    })
    $("#productshow").click(function(){
        $("#generic-form").submit();
    })




    $("body").on(".add-event","click", function(){
        $("#generic-form")[0].reset();

        $("#addevent").modal("show")
        $("#attribute").click();
    })

    $(".updateevent").click(function(){
        $('#image').prop('required', true);
        $("#image-add").css("display","none");
        $('#banner').prop('required', true);
        $("#banner-add").css("display","none");
        $("#generic-form")[0].reset();
        $("#record_id").attr("value","");
        $("#addevent").modal("show")
        $("#attribute").click();
    })






    $("body").on("click" ,".delete-record",function(){
        var id = $(this).data("id");
        var model = $(this).data("model");
        var is_active = 0;
        var is_deleted = 1;
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: "{{route('delete_record')}}",
            data: {id:id, model:model, is_active:is_active, is_deleted:is_deleted , _token: '{{csrf_token()}}'},
            success: function (response) {
                if (response.status == 0) {
                    toastr.error(response.message);
                }else{
                    var table = $('#example').DataTable();
                    // table.ajax.reload();
                    location.reload();
                    toastr.success(response.message);
                }
            }
        });
    })
    $(".anything").select2({
      tags: true
    });
    function convertToSlug( str ) {
      //replace all special characters | symbols with a space
      str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
      // trim spaces at start and end of string
      str = str.replace(/^\s+|\s+$/gm,'');
      // replace space with dash/hyphen
      str = str.replace(/\s+/g, '-');   
      document.getElementById("slug").value = str;
      //return str;
    }

    

    $("#attribute").click(function(){
        var otype = $(this).children("option:selected").val();
        if (otype == "roles") {
            $("#role-label").show();
            $("#rank-label").show();
        }else if(otype == "departments"){
            $("#role-label").hide();
            $("#rank-label").show();
        }else if(otype == "designations"){
            $("#role-label").hide();
            $("#rank-label").show();
        }
        else if(otype == "project"){
            $("#role-label").hide();
            $("#rank-label").show();
        }
    })
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

</script>
<script type="text/javascript">
  $("#former-submit").click(function(){
    $("#assign-role-form").submit();
  })


</script>
@endsection
