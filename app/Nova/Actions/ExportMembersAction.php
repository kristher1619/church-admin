<?php

namespace App\Nova\Actions;

use App\Exports\MembersExport;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ExportMembersAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $fileName = now()->toDateString() . "-members.csv";
        $response = Excel::download(new MembersExport(), $fileName, \Maatwebsite\Excel\Excel::CSV, [ 'Content-Type' => 'text/csv']);

        return Action::download($this->getDownloadUrl($response->getFile()->getPathname(), $fileName), $fileName);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    /**
     * @param  string  $filePath
     * @param string fileName
     * @return string
     */
    protected function getDownloadUrl(string $filePath, string $fileName): string
    {
        return URL::temporarySignedRoute('laravel-nova-excel.download', now()->addMinutes(1), [
            'path' => encrypt($filePath),
            'filename' => $fileName,
        ]);
    }

}
