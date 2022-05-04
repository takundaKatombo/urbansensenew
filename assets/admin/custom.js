
/*check sure to delete ? */

$('.delete-button').click(function () {
 	return confirm('Are you sure you want to delete?');
});


$('.refund-button').click(function () {
    return confirm('Are you sure you want to refund?');
});


function validate(form) {
    return confirm('Do you really want to payout?');
    
}


$('.criminal_varification').click(function() {
    var id = $(this).attr('id');
    var data_string = 'id=' + id;
    $.ajax({
        type: "POST",
        data: data_string,
        url: base_url + 'admin/Professionals/criminal_varification/'+id,
        success: function (data) {
            var result = JSON.parse(data);
             alert(result.message);

        }
    });
});

$('.bank_varification').click(function() {
    var id = $(this).attr('id');
    var data_string = 'id=' + id;
    $.ajax({
        type: "POST",
        data: data_string,
        url: base_url + 'admin/Professionals/bank_varification/'+id,
        success: function (data) {
            var result = JSON.parse(data);
             alert(result.message);

        }
    });
});

$('.skill_assessment').click(function() {
    var id = $(this).attr('id');
   

    var data_string = 'id=' + id;
    $.ajax({
        type: "POST",
        data: data_string,
        url: base_url + 'admin/Professionals/skill_assessment/'+id,
        success: function (data) {
            var result = JSON.parse(data);
             alert(result.message);

        }
    });
});


$('.make_default').click(function() {
        var id = $(this).attr('id');
        var data_string = 'id=' + id;
        $.ajax({
            type: "POST",
            data: data_string,
            url: base_url + 'admin/Categories/make_default/'+id,
            success: function (data) {
                var result = JSON.parse(data);
                 alert(result.message);
            }
        });
    }); 

$('.featured_service_provider').click(function() {
        var id = $(this).attr('id');
        var data_string = 'id=' + id;
        $.ajax({
            type: "POST",
            data: data_string,
            url: base_url + 'admin/Professionals/featured_service_provider/'+id,
            success: function (data) {
                var result = JSON.parse(data);
                alert(result.message);

            }
        });
    });

$('.show_on_homepage').click(function() {
   // alert('hello');
        var id = $(this).attr('id');
        var data_string = 'id=' + id;
        $.ajax({
            type: "POST",
            data: data_string,
            url: base_url + 'admin/Reviews/show_on_homepage/'+id,
            success: function (data) {
                var result = JSON.parse(data);
                alert(result.message);

            }
        });
    });




            $('.text-editor').each(function () {


//                CKEDITOR.replace($(this).attr('id'), {
//                    filebrowserBrowseUrl: '<?= base_url('assets/ckfinder/ckfinder.html') ?>',
//                    filebrowserImageBrowseUrl: '<?= base_url('assets/ckfinder/ckfinder.html?type=Images') ?>',
//                    filebrowserUploadUrl: '<?= base_url('assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/') ?>',
//                    filebrowserImageUploadUrl: '<?= base_url('assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/') ?>'
//
//                });
                CKEDITOR.replace($(this).attr('id'));

            });

$(document).ready(function() {
    $('#datatable').DataTable({
        lengthMenu: [50, 100, 200, 500],
    });
} );

