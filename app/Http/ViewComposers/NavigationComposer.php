<?php

namespace App\Http\ViewComposers;

use DB;

class NavigationComposer
{
    public function compose($view)
    {
        $navigation = DB::table('raceedition')
            ->select('edition_ID', 'editionname', 'race_abbr', 'edition_nr')
            ->leftJoin('race', 'raceedition.race_ID', '=', 'race.race_ID')
            ->get();
        $view->with('menu', $navigation);
    }
}
