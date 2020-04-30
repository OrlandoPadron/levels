<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];
        $name = trim($this->search);

        /**
         * Special codes
         * !entrenadores -> returns all the trainers in the database
         * !deportistas -> returns all the athletes in the database 
         */
        if ($name == '!entrenadores') {
            $searchResults = User::query()
                ->where('isTrainer', '1')->orderBy('name')->get();
            return view('livewire.search-dropdown', ['searchResults' => $searchResults]);
        } elseif ($name == "!deportistas") {
            $searchResults = User::query()
                ->where('isTrainer', '0')->orderBy('name')->get();
            return view('livewire.search-dropdown', ['searchResults' => $searchResults]);
        }

        if (strlen($name) >= 3) {

            if (sizeof(explode(' ', $name)) == 1) {
                $searchResults = User::query()
                    ->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('surname', 'LIKE', '%' . $name . '%')->get();
            } else {

                /**
                 * TODO: check if method runs properly 
                 * In case the user inserts different combinations of a name ; 
                 * ? For example: surname + name  
                 */
                /**Case name + surname*/
                $fullname = explode(' ', $name);
                $searchResults = User::query()
                    ->where('name', 'LIKE', '%' . $fullname[0] . '%')
                    ->where('surname', 'LIKE', '%' . $fullname[1] . '%')
                    ->get();
            }
        }

        return view('livewire.search-dropdown', ['searchResults' => $searchResults]);
    }
}
