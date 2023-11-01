<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Deck;
use mtgsdk\Card;

class MainController extends Controller
{
    public function index()
    {
        $cards = Card::where(['page' => 1, 'pageSize' => 100])->all();
        $deck = Deck::all();
        $mana = 0;

        foreach ($deck as $item => $card) {
            if (isset($card->multiverseid) && $card->cmc) {
                $mana += intval($card->cmc);
            }
        }

        return view('magic', compact('cards', 'deck', 'mana'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:50',
        ]);

        $cards = Card::where(['name' => $request->input('search')])->where(['page' => 1, 'pageSize' => 100])->all();

        if (count($cards) == 0)
        {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'result' => false,
            ]);
        }

        $list = '';
        $default = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg';

        foreach ($cards as $item => $card)
        {
            if (isset($card->multiverseid))
            {
                $list .= '
                    <tr>
                        <td><img src="' . ($card->imageUrl ?? $default) . '" class="img-fluid rounded" alt="' . $card->name . '" width="100"></td>
                        <td>' . ($card->number ?? '---') . '</td>
                        <td>' . ($card->name ?? '---') . '</td>
                        <td>' . ($card->type ?? '---') . '</td>
                        <td>' . ($card->rarity ?? '---') . '</td>
                        <td>' . (isset($card->colorIdentity) ? json_encode($card->colorIdentity) : '---') . '</td>
                        <td>' . ($card->cmc ?? '---') . '</td>
                        <td>' . ($card->multiverseid ?? '---') . '</td>
                        <td>
                            <a href="' . route('magic.card', $card->multiverseid) . '" class="cardDetails btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cardDetails" title="SEE DETAILS"><i class="fa fa-fw fa-eye"></i></a>
                            <a href="' . route('magic.include', $card->multiverseid) . '" class="cardInclude btn btn-sm btn-outline-secondary" title="ADD TO DECK"><i class="fa fa-fw fa-plus"></i></a>
                        </td>
                    </tr>
                ';
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'result' => $list
        ]);
    }

    public function card($id)
    {
        $card = Card::find($id);

        if (!isset($card))
        {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'result' => false,
            ]);
        }

        $default = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg';
        $details = '
            <div class="text-center">
                <img src="' . ($card->imageUrl ?? $default) . '" class="img-fluid w-100 rounded mb-3" alt="' . $card->name . '">
            </div>
            <hr>
            <h5 class="card-title">' . ($card->name ?? '---') . '</h5>
            <h6 class="card-subtitle text-muted">' . ($card->type ?? '---') . '</h6>
            <hr>
            <div class="card-text row">
                <div class="col">
                    <small>
                        <b>CMC:</b> ' . ($card->cmc ?? '---') . '<br>
                        <b>Number:</b> ' . ($card->number ?? '---') . '<br>
                        <b>Rarity:</b> ' . ($card->rarity ?? '---') . '<br>
                        <b>Colors:</b> ' . (isset($card->colorIdentity) ? json_encode($card->colorIdentity) : '---') . '<br>
                        <b>Mana Cost:</b> ' . ($card->manaCost ?? '---') . '<br>
                        <b>Multiverse ID:</b> ' . ($card->multiverseid ?? '---') . '
                    </small>
                </div>
                <div class="col">
                    <small>
                        <b>Set:</b> ' . ($card->set ?? '---') . '<br>
                        <b>Set Name:</b> ' . ($card->setName ?? '---') . '<br>
                        <b>Artist:</b> ' . ($card->artist ?? '---') . '<br>
                        <b>Types:</b> ' . (isset($card->types) ? json_encode($card->types) : '---') . '<br>
                        <b>Subtypes:</b> ' . (isset($card->subtypes) ? json_encode($card->subtypes) : '---') . '<br>
                        <b>Power:</b> ' . ($card->power ?? '---') . '
                    </small>
                </div>
            </div>
            <hr>
            <p>' . ($card->text ?? '---') . '</p>
            <p>' . ($card->flavor ?? '---') . '</p>
        ';

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'result' => $details
        ]);
    }

    public function details($id)
    {
        $card = Deck::find($id);

        if (!isset($card))
        {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'result' => false,
            ]);
        }

        $default = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg';
        $details = '
            <div class="text-center">
                <img src="' . ($card->imageUrl ?? $default) . '" class="img-fluid w-100 rounded mb-3" alt="' . $card->name . '">
            </div>
            <hr>
            <h5 class="card-title">' . ($card->name ?? '---') . '</h5>
            <h6 class="card-subtitle text-muted">' . ($card->type ?? '---') . '</h6>
            <hr>
            <div class="card-text row">
                <div class="col">
                    <small>
                        <b>CMC:</b> ' . ($card->cmc ?? '---') . '<br>
                        <b>Number:</b> ' . ($card->number ?? '---') . '<br>
                        <b>Rarity:</b> ' . ($card->rarity ?? '---') . '<br>
                        <b>Colors:</b> ' . (isset($card->colorIdentity) ? json_encode($card->colorIdentity) : '---') . '<br>
                        <b>Mana Cost:</b> ' . ($card->manaCost ?? '---') . '<br>
                        <b>Multiverse ID:</b> ' . ($card->multiverseid ?? '---') . '
                    </small>
                </div>
                <div class="col">
                    <small>
                        <b>Set:</b> ' . ($card->set ?? '---') . '<br>
                        <b>Set Name:</b> ' . ($card->setName ?? '---') . '<br>
                        <b>Artist:</b> ' . ($card->artist ?? '---') . '<br>
                        <b>Types:</b> ' . (isset($card->types) ? json_encode($card->types) : '---') . '<br>
                        <b>Subtypes:</b> ' . (isset($card->subtypes) ? json_encode($card->subtypes) : '---') . '<br>
                        <b>Power:</b> ' . ($card->power ?? '---') . '
                    </small>
                </div>
            </div>
            <hr>
            <p>' . ($card->text ?? '---') . '</p>
            <p>' . ($card->flavor ?? '---') . '</p>
        ';

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'result' => $details
        ]);
    }

    public function include($id)
    {
        $card = Card::find($id);

        if (!isset($card))
        {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'result' => false,
            ]);
        }

        Deck::create([
            'number' => intval($card->number),
            'name' => $card->name,
            'type' => $card->type ?? NULL,
            'imageUrl' => $card->imageUrl ?? NULL,
            'cmc' => intval($card->cmc ?? 0),
            'rarity' => $card->rarity ?? NULL,
            'manaCost' => isset($card->manaCost) ? json_encode($card->manaCost) : NULL,
            'colorIdentity' => isset($card->colorIdentity) ? json_encode($card->colorIdentity) : NULL,
            'multiverseid' => $card->multiverseid ?? NULL,
            'set' => $card->set ?? NULL,
            'setName' => $card->setName ?? NULL,
            'artist' => $card->artist ?? NULL,
            'types' => isset($card->types) ? json_encode($card->types) : NULL,
            'subtypes' => isset($card->subtypes) ? json_encode($card->subtypes) : NULL,
            'power' => intval($card->power ?? 0),
            'text' => $card->text ?? NULL,
            'flavor' => $card->flavor ?? NULL,
        ]);

        $deck = Deck::all();
        $mana = 0;
        $list = '';
        $default = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg';

        foreach ($deck as $item => $card) {
            if (isset($card->multiverseid)) {
                $mana += intval($card->cmc);
                $list .= '
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body custom-card p-2">
                                <div class="text-center">
                                    <img src="' . ($card->imageUrl ?? $default) . '" class="img-fluid w-100 rounded mb-3" alt="' . $card->name . '">
                                </div>
                                <h5 class="card-title">' . ($card->name ?? '---') . '</h5>
                                <h6 class="card-subtitle text-muted">' . ($card->type ?? '---') . '</h6>
                                <hr>
                                <div class="row text-center">
                                    <div class="col pr-0">
                                        <a href="' . route('magic.card', $card->multiverseid) . '" class="cardDetails btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cardDetails" title="SEE DETAILS"><i class="fa fa-fw fa-eye"></i></a>
                                    </div>
                                    <div class="col px-0">
                                        <h6 class="text-center text-danger my-0" style="top:-5px; position: relative;"><small class="text-muted">cmc</small><br>' . ($card->cmc ?? '---') . '</h6>
                                    </div>
                                    <div class="col pl-0">
                                        <a href="' . route('magic.exclude', $card->id) . '" class="cardExclude btn btn-sm btn-outline-secondary" title="REMOVE FROM DECK"><i class="fa fa-fw fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'result' => $list,
            'mana' => $mana,
            'cant' => count($deck)
        ]);
    }

    public function exclude($id)
    {
        $card = Deck::find($id);

        if (!isset($card))
        {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'result' => false,
            ]);
        }

        $card->delete();

        $deck = Deck::all();
        $mana = 0;
        $list = '';
        $default = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Magic_the_gathering-card_back.jpg/220px-Magic_the_gathering-card_back.jpg';

        if (count($deck) == 0)
        {
            $list .= '
                <div class="col text-center text-white my-5 py-5">
                    <h4 class="alert-heading">No Cards in your Deck!</h4>
                    <p>There are no cards in your deck. Add some cards to your deck.</p>
                    <hr>
                    <p class="mb-0 text-muted">Click on the button below to search for new cards.</p>
                    <br>
                    <button type="button" class="btn btn-dark text-uppercase" data-bs-toggle="modal" data-bs-target="#cardFinder">Search for new Cards</button>
                    <br><br>
                </div>
            ';
        } else {
            foreach ($deck as $item => $card) {
                if (isset($card->multiverseid)) {
                    $mana += intval($card->cmc);
                    $list .= '
                        <div class="col-6 col-md-4 col-xl-2">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body custom-card p-2">
                                    <div class="text-center">
                                        <img src="' . ($card->imageUrl ?? $default) . '" class="img-fluid w-100 rounded mb-3" alt="' . $card->name . '">
                                    </div>
                                    <h5 class="card-title">' . ($card->name ?? '---') . '</h5>
                                    <h6 class="card-subtitle text-muted">' . ($card->type ?? '---') . '</h6>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col pr-0">
                                            <a href="' . route('magic.card', $card->multiverseid) . '" class="cardDetails btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cardDetails" title="SEE DETAILS"><i class="fa fa-fw fa-eye"></i></a>
                                        </div>
                                        <div class="col px-0">
                                            <h6 class="text-center text-danger my-0" style="top:-5px; position: relative;"><small class="text-muted">cmc</small><br>' . ($card->cmc ?? '---') . '</h6>
                                        </div>
                                        <div class="col pl-0">
                                            <a href="' . route('magic.exclude', $card->id) . '" class="cardExclude btn btn-sm btn-outline-secondary" title="REMOVE FROM DECK"><i class="fa fa-fw fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'result' => $list,
            'mana' => $mana,
            'cant' => count($deck)
        ]);
    }
}
