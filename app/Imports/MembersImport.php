<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection) {
        Member::upsert($this->mapFields($collection)->toArray(), ['first_name', 'last_name'], [ 'first_name', 'last_name', 'middle_name', 'dob', 'date_of_baptism', 'membership_status', 'date_died', 'sex']);
    }

    public function mapFields(Collection $collection): Collection
    {
       return $collection->map(function($value) {
          return [
              'first_name' => $value['First Name'],
              'last_name' => $value['Last Name'],
              'middle_name' => $value['Middle Name'],
              'dob' => $value['Date of Birth'],
              'date_of_baptism' => $value['Date of Baptism'],
              'membership_status' => $value['Membership Status'],
              'date_died'=> $value['Date Died'],
              'sex' => $value['Sex'],
          ];
       });
    }
}
