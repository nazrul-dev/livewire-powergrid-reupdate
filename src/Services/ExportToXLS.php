<?php


namespace PowerComponents\LivewirePowerGrid\Services;


use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Services\Contracts\ExportInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportToXLS extends Export implements ExportInterface
{

    /**
     * @throws Exception
     */
    public function download(): BinaryFileResponse
    {
        Storage::disk('public')->put($this->fileName . '.xlsx', $this->build());

        return response()
            ->download(storage_path("app/public/" . $this->fileName . '.xlsx'));
    }

    public function build()
    {
        $data = $this->prepare($this->collection, $this->columns, $this->checked_values);
        return \SimpleXLSXGen::fromArray($data, $this->fileName);
    }

}