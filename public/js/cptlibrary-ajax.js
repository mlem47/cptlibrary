(function($){

    $(document).ready(function(){

        $(document).on('click', '.js-filter-item > a', function (e){

            e.preventDefault();

            var category = $(this).data('category');

            $.ajax({
                url:wp_ajax.ajax_url,
                data:{ action: 'filter', category: category }, // form data
                type:'post',
                success:function(result){
                    $('[data-js-filter=target]').html(result); // insert data
                },
                error:function(result){
                    console.warn(result);
                }
                
            });
        });
    });
})(jQuery);
