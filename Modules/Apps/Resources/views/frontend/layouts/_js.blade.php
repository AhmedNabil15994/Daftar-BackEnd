{{-- ADD / UPDATE  ITEMS TO SHOPPING CART--}}
<script>
    $(document).ready(function() {

        $('.form').on('submit',function(e) {
            e.preventDefault();

            var url     = $(this).attr('action');
            var method  = $(this).attr('method');

            $.ajax({

                url: url,
                type: method,
                dataType: 'JSON',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function(){
                  $(".inner-page").addClass('disabled');
                  $('#loading').removeClass('hidden');
                },
                success:function(data){
                  displaySuccess(data['message']);
                  $('.add_to_cart').prop('disabled',false);
                  shoppingCart();
                },
                error: function(data){
                  console.log(data);
                  displayErrors(data);
                  $('.add_to_cart').prop('disabled',false);
                  shoppingCart();
                },
                complete:function(data){
                  $(".inner-page").removeClass('disabled');
                  $('#loading').addClass('hidden');
                },
            });

        });

    });

    function displayErrors(data)
    {
        console.log($.parseJSON(data.responseText));

        var getJSON = $.parseJSON(data.responseText);

        var output = '<ul>';

        for (var error in getJSON.errors){
            output += "<li>" + getJSON.errors[error] + "</li>";
        }

        output += '</ul>';

        var wrapper = document.createElement('div');
        wrapper.innerHTML = output;

        swal({
          content: wrapper,
          icon: "error",
          dangerMode: true,
        })
    }


    function displaySuccess(data)
    {
        swal({
          closeOnClickOutside: false,
          closeOnEsc: false,
          text: data,
          icon: "success",
          buttons: {
            success: {
              text: "{{ __('catalog::frontend.cart.btn.got_to_shopping_cart') }}",
              value: 'redirect',
              className: 'btn btn-theme',
            },
            close: {
              className: 'btn btn-continue',
              text: "{{ __('catalog::frontend.cart.btn.continue') }}",
              value: 'close',
              closeModal: true
            },
          }
        })
        .then((value) => {
          switch (value) {
            case "redirect":
              window.location.replace("{{ url(route('frontend.shopping-cart.index')) }}");
              break;
          }
        });
    }

</script>


<script>
	function shoppingCart()
	{
		$.ajax({
	        url: '{{ url(route('frontend.shopping-cart.header')) }}',
	        type: "GET",
	        success:function(res){
		        $(".shopping_cart").html(res);
	        },
	        error:function(res){
	        }
	    });
	}
</script>


<script>
    $(document).ready(function() {

        $('.favorite').on('click',function(e) {
            e.preventDefault();

            var url     = $(this).attr('href');
            var method  = 'GET';

            $.ajax({

                url: url,
                type: method,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function(){
                  $(".inner-page").addClass('disabled');
                  $('#loading').removeClass('hidden');
                },
                success:function(data){
                  displaySuccessFavorite(data['message']);
                },
                error: function(data){
                  displayErrorsFavorite(data);
                },
                complete:function(data){
                  $(".inner-page").removeClass('disabled');
                  $('#loading').addClass('hidden');
                },
            });

        });

    });


    function displayErrorsFavorite(data)
    {
        console.log($.parseJSON(data.responseText));

        var getJSON = $.parseJSON(data.responseText);

        var output = '<ul>';

        for (var error in getJSON.errors){
            output += "<li>" + getJSON.errors[error] + "</li>";
        }

        output += '</ul>';

        var wrapper = document.createElement('div');
        wrapper.innerHTML = output;

        swal({
          content: wrapper,
          icon: "error",
          dangerMode: true,
        })
    }


    function displaySuccessFavorite(data)
    {
        swal({
          closeOnClickOutside: false,
          closeOnEsc: false,
          text: data,
          icon: "success",
          buttons: {
            success: {
              text: "{{ __('catalog::frontend.favorites.btn.got_to_favorite_list') }}",
              value: 'redirect',
              className: 'btn btn-success',
            },
            close: {
              className: 'btn btn-default',
              text: "{{ __('catalog::frontend.favorites.btn.continue') }}",
              value: 'close',
              closeModal: true
            },
          }
        })
        .then((value) => {
          switch (value) {
            case "redirect":
              window.location.replace("{{ url(route('frontend.favorites.index')) }}");
              break;
          }
        });
    }

</script>

<script>
    $(document).ready(function () {
        if($(window).width() < 768) {
           $(".lang-switcher").removeClass("lang-switcher");
        }
    });
</script>
