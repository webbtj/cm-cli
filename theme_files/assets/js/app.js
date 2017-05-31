(function($) {

    $(document).ready(function() {

        function load_posts(){
            $page = parseInt($('#post-page').val());
            $page += 1;
            $('#post-page').val($page);

            var data = {
                'type' : $('#post-type').val(),
                'page' : $page,
                'action' : 'load_posts'
            }

            //--Taxonomy Ajax Property

            if($('#post-year').val()){
                data.year = $('#post-year').val();
            }
            if($('#post-month').val()){
                data.month = $('#post-month').val();
            }

            $.get("/wp-admin/admin-ajax.php", data, function(r){

                $('.load-more').remove();

                $('#posts').append(r);
            });
        }

        function check_month(){
            if(!$('#post-year').val()){
                $('#post-month option').prop('selected', false);
                $('#post-month option:first').prop('selected', true);
                $('#post-month').prop('disabled', true);
            }else{
                $('#post-month').prop('disabled', false);
            }
        }

        check_month();

        $('body').on('click', '#load-more', function(e){
            $(this).addClass('active');
            if(!$(this).hasClass('disabled'))
                load_posts();
            e.preventDefault();
        });

        //--Taxonomy Filter Trigger

        $('#post-month').on('change', function(e){
            $('#posts').empty();
            $('#post-page').val('0');
            load_posts();
            e.preventDefault();
        });

        $('#post-year').on('change', function(e){
            check_month();
            $('#posts').empty();
            $('#post-page').val('0');
            load_posts();
            e.preventDefault();
        });

        $('#search-anchor, #search-anchor-mobile').on('click', function(e){
            $(this).parent().submit();
            e.preventDefault();
        });

    });
})(jQuery);
