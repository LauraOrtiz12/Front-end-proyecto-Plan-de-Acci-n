<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\EstateIndicator;
use App\Models\EstateIndicatorSave;
use App\Models\FollowClose;
use App\Models\FollowUp;
use App\Models\IndicatorMoney;
use App\Models\IndicatorMoneySave;
use App\Models\Validity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;

class PollController extends Controller
{

    public function index() {
        return Inertia::render('Polls/CreatePoll');
    }
}
