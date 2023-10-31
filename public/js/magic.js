$(document).ready(function() {
    $('#cardFinder').on('shown.bs.modal', function () {
        $('#searchForm input').trigger('focus');
    })

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        axios
            .post(url, data)
            .then(function (response) {
                if (response.data.status == 'success') {
                    $('#searchResult').html(response.data.result);
                } else {
                    $('#searchResult').html('<tr><td colspan="9" class="text-center"><h4 class="alert-heading">No Cards Found!</h4><p>There are no cards for your search. Try by searching with a different search terms.</p></td></tr>');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    $('body').on('click', '.cardDetails', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        axios
            .get(url)
            .then(function (response) {
                if (response.data.status == 'success') {
                    $('#cardDetailBox').html(response.data.result);
                } else {
                    $('#cardDetailBox').html('<h4 class="alert-heading">Card doesn\'t exists!</h4><p>There are no details for this card.</p>');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    $('body').on('click', '.cardInclude', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        axios
            .get(url)
            .then(function (response) {
                if (response.data.status == 'success') {
                    $('#cardsDeck').html(response.data.result);
                    $('#manaCost').html(response.data.mana);
                } else {
                    $('#cardsDeck').html('<div class="col text-center text-white"><h4 class="alert-heading">No Cards in Deck!</h4><p>There are no cards in your deck. Please add some cards to your deck.</p><hr><p class="mb-0 text-muted">Click on the button below to search for new cards.</p><br><button type="button" class="btn btn-dark text-uppercase" data-bs-toggle="modal" data-bs-target="#cardFinder">Search for new Cards</button><br><br></div>');
                    $('#manaCost').html('0');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    $('body').on('click', '.cardExclude', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        axios
            .get(url)
            .then(function (response) {
                if (response.data.status == 'success') {
                    $('#cardsDeck').html(response.data.result);
                    $('#manaCost').html(response.data.mana);
                } else {
                    $('#cardsDeck').html('<div class="col text-center text-white"><h4 class="alert-heading">No Cards in Deck!</h4><p>There are no cards in your deck. Please add some cards to your deck.</p><hr><p class="mb-0 text-muted">Click on the button below to search for new cards.</p><br><button type="button" class="btn btn-dark text-uppercase" data-bs-toggle="modal" data-bs-target="#cardFinder">Search for new Cards</button><br><br></div>');
                    $('#manaCost').html('0');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });
});
