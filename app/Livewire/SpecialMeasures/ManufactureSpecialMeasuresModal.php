<?php

namespace App\Livewire\SpecialMeasures;

use App\Helpers\Selector;
use App\Models\Dimension;
use App\Models\Product;
use App\Models\ProductSale;
use Illuminate\Support\Facades\Cache;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\DB;

class ManufactureSpecialMeasuresModal extends ModalComponent
{
    use WireUiActions;

    public ProductSale $productSale;

    public Product|null $currentProduct = null;

    public $products = [];

    public $width = null;

    public $height = null;

    public $filters = [
        'product_id'  => null,
        'dimension_id' => null,
        'type' => 'COLCHON'
    ];

    protected function rules()
    {
        return [
            'currentProduct' => 'required',
            'currentProduct.stock' => 'required|integer|gte:'. (int)$this->productSale->CANLFA
        ];
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public static function closeModalOnEscapeIsForceful(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public function mount(ProductSale $productSale):void
    {
        $this->productSale = $productSale;

        $DESLFA = strtoupper($this->productSale->DESLFA);

        preg_match('/\d+(X\d+)+/', $DESLFA, $matches);

        if (count($matches))
        {
            list($width, $height) = explode('X', $matches[0]);

            $this->height = (float) $height;

            $this->width = (float) $width;

            $this->products = Product::whereHas('dimension', function ($query) {
                $query->where([
                    ['width', '>=', (float) $this->width],
                    ['height', '>=', (float) $this->height],
                ]);
            })
            ->take(3)
            ->get();
        }
    }

    public function render()
    {
        return view('livewire.special-measures.manufacture-special-measures-modal');
    }

    public function submit (): void
    {
        $this->validate();

        $CANLFA = (int)$this->productSale->CANLFA;

        $this->currentProduct->decrementStock($CANLFA);

        $this->productSale->special_measurement()->create([
            'quantity' => $CANLFA,
            'product_id' => $this->currentProduct->id
        ]);

        $this->notification()->success(
            __("Se ha fabricado exitosamente"),
        );

        $this->closeModal();
    }

    public function removeProduct (): void
    {
        $this->currentProduct = null;
    }

    public function addProductFilters (): void
    {
        $product = Product::find($this->filters['product_id']);

        if ($product)
            $this->currentProduct = $product;
        else
            $this->notification()->error(__('Producto no encontrado.'));
    }

    public function selectProduct (Product $product): void
    {
        $this->currentProduct = $product;
    }

    public function getDimensionsProperty ()
    {
        $dimensions = Dimension::orderBy('width')
            ->selectRaw('id, code as label, COALESCE(description, label) as description, CONCAT(width, " x ", height) as dimensions')
            ->select('description', 'height','width', 'id')
            ->when($this->filters['type'], function ($query) {
                $query->whereRelation('products', 'type', $this->filters['type']);
            })
            ->pluck('description', 'id')
            ->toArray();


        return array_merge(['' => __('DImensions')], $dimensions);
    }

    public function getProductTypesProperty ()
    {
        return Selector::productTypes();
    }

    public function getPathAsyncDataProperty (): array
    {
        return [
            'api' => route('api.parts.index'),
            'method' => 'GET',
            'params' => [
                'type' => optional($this->filters)['type'],
                'dimension_id' => optional($this->filters)['dimension_id'],
            ]
        ];
    }
}
