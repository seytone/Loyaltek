<!doctype html>
<html lang="en">

<head>
    <title>Magic: The Gathering | Loyaltek Assessment</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" sizes="16x16" href="https://magic.wizards.com/assets/favicon.ico">

    <!-- Font Awesome v4.7.0 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Sweet Alert -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/magic.css') }}" rel="stylesheet" />
</head>

<body class="bg-dark">
    <header>
        <div class="container-fluid text-center pt-1 pb-1">
            <div class="row">
                <div class="col text-center">
                    <img src="https://media.wizards.com/2018/images/magic/gatherer/magic_logo.png" class="img-fluid" alt="Magic The Gathering Logo">
                </div>
            </div>
        </div>
    </header>
    <section class="container-fluid">
        <div class="bg"></div>
        <div class="layer"></div>
        <main class="main pt-5 pb-4">
            <div class="row text-center">
                <div class="col-md-8 offset-md-2 col-xl-6 offset-xl-3 my-4">
                    <h1 class="text-danger">Magic: The Gathering</h1>
                    <h5 class="text-muted">A Loyaltek Assessment Test for a PHP Full Stack Positon</h5>
                    <br>
                    <button type="button" class="btn btn-dark text-uppercase" data-bs-toggle="modal" data-bs-target="#cardFinder">Search for new Cards</button>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1 col-xl-8 offset-xl-2">
                    <div class="row border-bottom border-danger mb-3">
                        <div class="col-12 col-md-6 text-center text-md-start">
                            <h2 class="text-warning">Your Deck</h2>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-white text-center text-md-end mt-2">Card Counter: <strong id="cardsCounter">{{ count($deck) }}</strong> - Average Mana Cost: <strong id="manaCost">{{ $mana }}</strong></h6>
                        </div>
                    </div>
                    <div class="row" id="cardsDeck">
                        @if (count($deck) == 0)
                            <div class="col text-center text-white my-5 py-5">
                                <h4 class="alert-heading">No Cards in your Deck!</h4>
                                <p>There are no cards in your deck. Add some cards to your deck.</p>
                                <hr>
                                <p class="mb-0 text-muted">Click on the button below to search for new cards.</p>
                                <br>
                                <button type="button" class="btn btn-dark text-uppercase" data-bs-toggle="modal" data-bs-target="#cardFinder">Search for new Cards</button>
                                <br><br>
                            </div>
                        @else
                            @foreach ($deck as $item => $card)
                                @if (isset($card->multiverseid))
                                    <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                                        <div class="card bg-dark text-white mb-4">
                                            <div class="card-body custom-card p-2">
                                                <div class="text-center">
                                                    <img src="{{ $card->imageUrl ?? 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg' }}" class="img-fluid w-100 rounded mb-3" alt="{{ $card->name }}">
                                                </div>
                                                <h5 class="card-title">{{ $card->name ?? '---' }}</h5>
                                                <h6 class="card-subtitle text-muted">{{ $card->type ?? '---' }}</h6>
                                                <hr>
                                                <div class="row text-center">
                                                    <div class="col pr-0">
                                                        <a href="{{ route('magic.details', $card->id) }}" class="cardDetails btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cardDetails" title="SEE DETAILS"><i class="fa fa-fw fa-eye"></i></a>
                                                    </div>
                                                    <div class="col px-0">
                                                        <h6 class="text-center text-danger my-0 cmc"><small class="text-muted">cmc</small><br>{{ $card->cmc ?? '---' }}</h6>
                                                    </div>
                                                    <div class="col pl-0">
                                                        <a href="{{ route('magic.exclude', $card->id) }}" class="cardExclude btn btn-sm btn-outline-secondary" title="REMOVE FROM DECK"><i class="fa fa-fw fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </section>
    <footer>
        <div class="container-fluid pt-3 pb-3">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col text-center">
                    <img src="https://uploads-ssl.webflow.com/6132518f4d53a7d350727200/6132518f4d53a75df172722a_Logo.svg" class="img-fluid" alt="Loyaltek Logo" width="100">
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Cards Listing -->
    <div class="modal fade" id="cardFinder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cardFinderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content bg-secondary">
                <form class="modal-header text-center" id="searchForm" action="{{ route("magic.search") }}">
                    @csrf
                    <h3 class="text-white d-none d-md-block"><small>Card Finder</small></h3>
                    <div class="w-75">
                        <h3 class="text-white d-block d-md-none"><small>Cards Search Tool</small></h3>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Type something to search Cards" aria-label="Type something to search Cards" aria-describedby="button-addon2" required>
                            <button class="btn btn-outline-light" type="submit" id="button-addon2">Search</button>
                        </div>
                    </div>
                </form>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover table-primary align-middle">
                            <thead>
                                <tr>
                                    <th width="120">Card</th>
                                    <th>Number</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Rarity</th>
                                    <th>Colors</th>
                                    <th>CMC</th>
                                    <th>ID</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider" id="searchResult">
                                @foreach ($cards as $item => $card)
                                    @if (isset($card->multiverseid))
                                        <tr>
                                            <td><img src="{{ $card->imageUrl ?? 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg' }}" class="img-fluid rounded" alt="{{ $card->name }}"></td>
                                            <td>{{ $card->number ?? '---' }}</td>
                                            <td>{{ $card->name ?? '---' }}</td>
                                            <td>{{ $card->type ?? '---' }}</td>
                                            <td>{{ $card->rarity ?? '---' }}</td>
                                            <td>{{ isset($card->colorIdentity) ? json_encode($card->colorIdentity) : '---' }}</td>
                                            <td>{{ $card->cmc ?? '---' }}</td>
                                            <td>{{ $card->multiverseid ?? '---' }}</td>
                                            <td>
                                                <a href="{{ route('magic.card', $card->multiverseid) }}" class="cardDetails btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cardDetails" title="SEE DETAILS"><i class="fa fa-fw fa-eye"></i></a>
                                                <a href="{{ route('magic.include', $card->multiverseid) }}" class="cardInclude btn btn-sm btn-outline-secondary" title="ADD TO DECK"><i class="fa fa-fw fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Card Detail -->
    <div class="modal fade" id="cardDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cardDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header text-center">
                    <h3 class="text-white"><small>Card Details</small></h3>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="cardDetailBox">
                    <div class="text-center">
                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg" class="img-fluid rounded mb-3" alt="Lorem Ipsum">
                    </div>
                    <hr>
                    <h5 class="card-title">Lorem Ipsum</h5>
                    <h6 class="card-subtitle text-muted">Dolor Sit Amet</h6>
                    <hr>
                    <div class="card-text row">
                        <div class="col">
                            <small>
                                <b>CMC:</b> 0<br>
                                <b>Number:</b> 123<br>
                                <b>Rarity:</b> Developer<br>
                                <b>Colors:</b> RGB, CMKY<br>
                                <b>Mana Cost:</b> 0<br>
                                <b>Multiverse ID:</b> 123456789
                            </small>
                        </div>
                        <div class="col">
                            <small>
                                <b>Set:</b> E404<br>
                                <b>Set Name:</b> Foo<br>
                                <b>Artist:</b> Fizz Buzz<br>
                                <b>Types:</b> JS, PHP, CSS, AWS<br>
                                <b>Subtypes:</b> VUE, LARAVEL, BOOTSTRAP, EC2<br>
                                <b>Power:</b> 99
                            </small>
                        </div>
                    </div>
                    <hr>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <p>Nulla aliquam ducimus deserunt similique illum dolorum dolores laudantium eum magni rem ab et, odit aliquid eligendi ipsa maxime, ratione, doloremque minus.</p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-toggle="modal" data-bs-target="#cardFinder">Back to the List</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="{{ asset('js/magic.js') }}" type="text/javascript"></script>
</body>

</html>
