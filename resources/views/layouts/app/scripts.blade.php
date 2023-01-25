<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $(document).on('click', '.page-link', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page)
        {
            $.ajax({
            url:"?page="+page,
            success:function(data){
                $('#list_result').html(data);
            }
            });
        }
    });
    $(window).on('hashchange', function () {
        if (window.location.hash) {
            page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                load_list(page);
            }
        }
    });

    function handle_open_modal(url,modal,content){
        $.ajax({
            type: "GET",
            url: url,
            success: function (html) {
                $(content).html(html);
                $(modal).modal('show');
            },
            error: function () {
                $(content).html('<h3>Ajax Bermasalah !!!</h3>')
            },
        });
    }
</script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset('js/method.js') }}"></script>
<script src="{{ asset('js/confirm.js') }}"></script>
<script src="{{ asset('js/toastr.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
@yield('scripts')
