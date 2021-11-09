$(function () {
  $('#posts_table').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 1, "asc" ]],
    ajax  : window.location.href,
    columns: [
        {data: 'check', name:'check', orderable: false, searchable: false},
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {data: 'category', name: 'category'},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
  });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#show_img").html('<img src="' + e.target.result + '" width="40%"><button class="btn btn-danger ml-5 btn-sm" id="remove_img"><i class="fas fa-trash"></i></button>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click','#remove_img',function(){
    $("#remove_img").remove();
    $("#customFile").val("");
    $("#show_img").html('');
});

$("#remove_post_img").click(function(){
    $("#post_img").val("");
    $(".remove-img").html('');
});

function deletesingle(id,url,table) {
    var url = base_url + '/admin/' + url;
    title = table.replace('Datatable','');
    title = title.replace(/[_\W]+/g, " ");
    Swal.fire({
        title: 'Are you sure?',
        text: "Once deleted, you will not be able to recover this "+ title +" data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : url + '/' + id,
                type: 'POST',
                data : {"_token":csrftoken,_method: 'delete'},
                dataType:'json',
                success:function(data, textStatus, jqXHR) 
                {
                    if(data.status == 1)
                    {
                        Swal.fire(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                        )
                        $('#'+table).DataTable().ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails      
                }
            });
            
        }
    })
}

function MultipleDelete(url,table) {
    var url = base_url + '/admin/' + url;
    console.log(url);
    title = table.replace('Datatable','');
    title = title.replace(/[_\W]+/g, " ");
    var ids = [];
    $(':checkbox:checked').each(function(i){
        ids[i] = $(this).val();
    });
    if(ids.length > 0)
    {
        Swal.fire({
        title: 'Are you sure?',
        text: "Once deleted, you will not be able to recover this "+ title +" data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                    url : url,
                    type : 'post',
                    data : {"_token":csrftoken ,"ids":ids},
                    dataType:'json',
                    success:function(data, textStatus, jqXHR) 
                    { 
                        if(data.status == 1)
                        {
                            Swal.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            )
                            $('#'+table).DataTable().ajax.reload();
                            $(".select_all INPUT[type='checkbox'] ").prop("checked", false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        //if fails      
                    }
                });
            }
        });
    }
}

$(".select_all INPUT[type='checkbox'] ").click( function(e) {
    if($(this).prop("checked") == true){
        $(" INPUT[type='checkbox']").attr('checked', true);
    }
    else if($(this).prop("checked") == false){
        $(" INPUT[type='checkbox']").attr('checked', false);
    }
});