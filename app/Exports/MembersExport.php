<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromQuery, WithHeadings, WithMapping
{

    public function map($row): array
    {
        return [
            $row->id,
            $row->first_name,
            $row->middle_name,
            $row->last_name,
            $row->dob->toDateString(),
            $row->date_of_baptism?->toDateString(),
            $row->membership_status,
            $row->date_died?->toDateString(),
            $row->sex,
            $row->personal_information?->phone,
            $row->personal_information?->address_line_1,
            $row->personal_information?->address_line_2,
            $row->personal_information?->city,
            $row->personal_information?->state,
            $row->personal_information?->country,
            $row->personal_information?->postcode,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'First name',
            'Middle name',
            'Last name',
            'Date of birth',
            'Date of baptism',
            'Membership status',
            'Date died',
            'Sex',
            'Phone',
            'Address line 1',
            'Address line 2',
            'City',
            'Province',
            'Country',
            'Postcode'
        ];
    }

    public function query()
    {
        return Member::query();
    }

}
