<?php

namespace App\Exports;

use App\Models\SystemUsers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SystemUsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($privilege = null, $status = null)
    {
        $this->privilege = $privilege;
        $this->status = $status;
    }

    public function collection()
    {
        //return SystemUsers::all();
        $query = SystemUsers::query();

        if (!is_null($this->privilege)) {
            $query->where('privilege', $this->privilege);
        }

        if (!is_null($this->status)) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Branch ID',
            'Username',
            'Privilege',
            'Full Name',
            'Email',
            'Phone',
            'Receipt Printer ID',
            'Employee ID',
            'Group ID',
            'Is Debt Collect',
            'Collection Bureau ID',
            'Last Login Time',
            'Last Login IP',
            'Last Login User Agent',
            'Last Online',
            'Session Timeout',
            'TFA Phone',
            'TFA Email',
            'OTP Code',
            'Status',
            'Created By',
            'Created At',
            'Updated At',
        ];
    }
}
