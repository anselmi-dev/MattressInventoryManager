<?php

namespace App\Console\Contracts;

use Carbon\Carbon;

interface FactusolCommandContract
{
    public function reduceFactusol(array $item): array;

    public function getDataFactusol(): ?array;

    public function getLastUpdatedDateOf(): ?Carbon;

    public function getLastUpdatedDateRecords(): ?Carbon;

    public function getkeyCacheLastUpdatedDateOf(): string;

    public function setLastUpdatedDateOf(?Carbon $date = null): void;

    public function infoLastUpdatedDateOf(): void;

    public function optionForce(): bool;

    public function optionCode(): ?string;

    public function funcionNameFactusolService(): string;

    public function firstOrCreateRecord(array $data): void;
}
