<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyticsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @var mixed
     */
    private $university;

    public function __construct($university)
    {
        $this->university = $university;
    }

    /**
     * Return the collection of standings data.
     */
    public function collection()
    {
        return $this->university->standings()
            ->with(['team', 'sport'])
            ->get()
            ->map(function ($standing) {
                return [
                    $standing->sport->name,
                    $standing->team->name,
                    $standing->wins,
                    $standing->losses,
                    $standing->draws,
                    $standing->points,
                ];
            });
    }

    /**
     * Return column headings.
     */
    public function headings(): array
    {
        return [
            'Sport Name',
            'Team Name',
            'Wins',
            'Losses',
            'Draws',
            'Points',
        ];
    }

    /**
     * Return the title of the sheet.
     */
    public function title(): string
    {
        return 'Standings Report';
    }
}
