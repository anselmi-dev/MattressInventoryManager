<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Models\{
    Product,
    Dimension,
};

class AssociateDimensionProductJob implements ShouldQueue
{
    use Queueable;

    protected Product $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $code = $this->product->code;

        $dimention = $this->firstOrCreateDimensionByCode($code);

        if ($dimention) {

            $this->product->dimension()->associate($dimention);
            
            $this->product->saveQuietly();

            Cache::flush('count:dimensions');
        }
    }


    /**
     * First or Create Dimension by Product Code
     *
     * @param string $code
     * @return Dimension|null
     */
    protected function firstOrCreateDimensionByCode (string $code)
    {
        $xdimention = $this->getDimensionByString($code);
            
        if (is_null($xdimention))
            return null;

        $explode_dimention = explode('x', $xdimention);

        if (count($explode_dimention)) {
            return Dimension::firstOrCreate([
                'width' => (int) $explode_dimention[0],
                'height' => (int) $explode_dimention[1],
            ], [
                'visible' => true,
                'code' => 'DIMEN' . $xdimention,
                'description' => $xdimention,
            ]);
        }

        return null;
    }

    /**
     * Get 'WidthXHeight' by Product Code
     *
     * @param string $string
     * @return string|null
     */
    protected function getDimensionByString(string $string) {
        preg_match('/\d+x\d+/i', strtolower($string), $matches);

        return $matches[0] ?? null;
    }
}
