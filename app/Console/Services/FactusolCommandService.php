<?php

namespace App\Console\Services;

use App\Console\Contracts\FactusolCommandContract;
use App\Services\FactusolService;
use Carbon\Carbon;
use Illuminate\Console\Command;

abstract class FactusolCommandService extends Command implements FactusolCommandContract
{
    public function reduceFactusol(array $item): array
    {
        return array_reduce($item, function ($carry, $row) {
            $carry[$row->columna] = $row->dato;
            return $carry;
        }, []);
    }

    public function getDataFactusol(): ?array
    {
        $last_updated_date = $this->getLastUpdatedDateOf();

        $last_updated_date = !$this->optionForce() && $last_updated_date
            ? $last_updated_date
            : null;

        return (new FactusolService())->{$this->funcionNameFactusolService()}(last_updated_date: $last_updated_date, code: $this->optionCode());
    }

    public function getLastUpdatedDateOf(): ?Carbon
    {
        $last_updated_date = settings()->get($this->getkeyCacheLastUpdatedDateOf());

        return $last_updated_date
            ? Carbon::parse($last_updated_date)
            : null;
    }

    public function setLastUpdatedDateOf(?Carbon $date = null): void
    {
        $newDateUpdated = $date ? $date->toDateTimeString() : $this->getLastUpdatedDateRecords()->toDateTimeString();

        settings()->set($this->getkeyCacheLastUpdatedDateOf(), $newDateUpdated);
    }

    public function infoLastUpdatedDateOf(): void
    {
        $last_updated_date = $this->getLastUpdatedDateOf();

        $last_updated_date
            ? $this->info("Última fecha de procesamiento: " . $last_updated_date->toDateTimeString())
            : $this->info("No se encontró la fecha de procesamiento.");
    }
}
