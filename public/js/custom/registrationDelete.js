/* Remove registration */
function deleteRegistration(registration_ID) {
    var registration_ID = registration_ID;
    SwalDelete(registration_ID);
}
function SwalDelete(registration_ID){
    swal({
        title: 'Delete registration?',
        text: "Delete registration with ID: "+registration_ID+" ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,

        preConfirm: function() {
            return new Promise(function(resolve){
            $.ajax({
                dataType: 'json',
                type:'delete',
                url: '/registration-delete/' + registration_ID,
                data: {registration_ID, registration_ID},
            })
            .done(function(response){
                toastr.success('Registration Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                swal('Smazáno',response.message, response.status);
                var table = $('#dataTableBuilder').DataTable();
                table.ajax.reload();
            })
            .fail(function(){
                swal('Oops...', 'Something went wrong with ajax !', 'error');
            });
            });
        },
        allowOutsideClick: true
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});