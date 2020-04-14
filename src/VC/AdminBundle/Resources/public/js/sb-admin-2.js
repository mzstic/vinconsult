$(function() {

    $('#side-menu').metisMenu();

});

var deletePhotos = [];

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }



    $( "#sortable" ).sortable({
        update: function(event, ui) {
            var order = $( "#sortable" ).sortable("toArray", {attribute: 'data-id'});
            $('#form_sort').val(order);
        }
    });
    $( "#sortable" ).disableSelection();
    $('.photo .btn-remove').click(function(event){
        event.preventDefault();
        if (confirm('Opravdu chcete fotku odstranit?')) {
            deletePhotos.push($(this).parents('.photo').data('id'));
            $(this).parents('.photo').remove();
            var order = $( "#sortable" ).sortable("toArray", {attribute: 'data-id'});
            $('#form_sort').val(order);
            $('#form_delete').val(deletePhotos.join(','));
        }
    });

    $('#form_savePhotos').click(function(){
        var order = $( "#sortable" ).sortable("toArray", {attribute: 'data-id'});
        $('#form_sort').val(order);
    });


    Dropzone.options.photoUpload = {
        uploadMultiple: false,
        dictDefaultMessage: 'Sem přetáhněte soubory pro nahrání.'
    };

    $('#references-list').DataTable({
        paging: false
    });
});

