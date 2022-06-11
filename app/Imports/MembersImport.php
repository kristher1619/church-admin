<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection) {
        foreach($this->mapFields($collection) as $rows){
           $member = Member::updateOrCreate(['first_name' =>$rows['first_name'], 'last_name' => $rows['last_name']], $rows);
           $member->personal_information()->updateOrCreate(['member_id'=>$member->id], $rows);
        }

    }

    public function mapFields(Collection $collection): Collection
    {
       return $collection->map(function($value) {
          return [
              'first_name' => $value['first_name'],
              'last_name' => $value['last_name'],
              'middle_name' => $value['middle_name'],
              'dob' => $value['date_of_birth'],
              'date_of_baptism' => $value['date_of_baptism'],
              'membership_status' => $value['membership_status'],
              'date_died'=> $value['date_died'],
              'sex' => $value['sex'],
              'phone'=>$value['phone'],
              'address_line_1' => $value['address_line_1'],
              'address_line_2' => $value['address_line_2'],
              'city' => $value['city'],
              'state' => $value['province'],
          ];
       });
    }
}
