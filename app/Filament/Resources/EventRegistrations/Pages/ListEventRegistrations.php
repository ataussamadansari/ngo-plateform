<?php

namespace App\Filament\Resources\EventRegistrations\Pages;

use App\Filament\Resources\EventRegistrations\EventRegistrationResource;
use App\Models\EventRegistration;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventRegistrations extends ListRecords
{
    protected static string $resource = EventRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export Attendees CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $records = EventRegistration::with('event')->latest()->get();

                    $headers = [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename="event-attendees-'.now()->format('Y-m-d').'.csv"',
                    ];

                    $callback = function () use ($records) {
                        $handle = fopen('php://output', 'w');
                        // Add BOM for UTF-8 Excel support
                        fwrite($handle, "\xEF\xBB\xBF");

                        fputcsv($handle, [
                            'Event Title',
                            'Participant Name',
                            'Phone',
                            'Email',
                            'Role Assigned',
                            'Attendance Status',
                            'Registration Date',
                        ]);

                        foreach ($records as $reg) {
                            fputcsv($handle, [
                                $reg->event?->title ?? 'N/A',
                                $reg->participant_name,
                                $reg->participant_phone,
                                $reg->participant_email ?? 'N/A',
                                $reg->role_assigned ?? 'Attendee',
                                ucfirst($reg->attendance_status),
                                $reg->created_at?->format('Y-m-d H:i:s'),
                            ]);
                        }

                        fclose($handle);
                    };

                    return response()->stream($callback, 200, $headers);
                }),
        ];
    }
}
