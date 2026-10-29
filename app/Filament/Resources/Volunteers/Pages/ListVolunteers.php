<?php

namespace App\Filament\Resources\Volunteers\Pages;

use App\Filament\Resources\Volunteers\VolunteerResource;
use App\Models\Volunteer;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVolunteers extends ListRecords
{
    protected static string $resource = VolunteerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export Volunteers CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $records = Volunteer::latest()->get();

                    $headers = [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename="volunteers-roster-'.now()->format('Y-m-d').'.csv"',
                    ];

                    $callback = function () use ($records) {
                        $handle = fopen('php://output', 'w');
                        fwrite($handle, "\xEF\xBB\xBF");

                        fputcsv($handle, [
                            'Volunteer ID',
                            'Full Name',
                            'Phone',
                            'Email',
                            'City',
                            'Area of Interest',
                            'Skills',
                            'Availability',
                            'Status',
                            'Joined Date',
                        ]);

                        foreach ($records as $volunteer) {
                            $skills = is_array($volunteer->skills) ? implode(', ', $volunteer->skills) : ($volunteer->skills ?? '');
                            fputcsv($handle, [
                                $volunteer->volunteer_code ?? 'Pending',
                                $volunteer->full_name,
                                $volunteer->phone,
                                $volunteer->email ?? '',
                                $volunteer->city ?? '',
                                $volunteer->area_of_interest ?? '',
                                $skills,
                                ucfirst($volunteer->availability ?? 'Weekends'),
                                ucfirst($volunteer->status),
                                $volunteer->joined_at?->format('Y-m-d') ?? '',
                            ]);
                        }

                        fclose($handle);
                    };

                    return response()->stream($callback, 200, $headers);
                }),
        ];
    }
}
