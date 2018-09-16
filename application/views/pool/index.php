<h1>Hello World!</h1>
<button type="button" id="search">Search Tournaments</button>

<script>
    $(document).ready(function($) {
        var api_key = 'QHBqJfquiJhKm6nfhV6nodI5u2QgS7xqYSgXGW1l';
        var url = 'http://rgreenphoto:'+api_key+'@api.challonge.com/v1/tournaments.json';
        console.log(url);
        $.getJSON(url, function(data) {
            console.log('getJSON');
            console.log(data);
        });
        $('#search').click(function(e) {
            e.preventDefault();
            console.log(url);

            $.ajax({
                method: "GET",
                url: url
            }).success(function(data) {
                console.log('done');
                console.log(data);
            });
        });


    });


</script>