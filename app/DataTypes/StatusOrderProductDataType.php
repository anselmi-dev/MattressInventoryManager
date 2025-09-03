<?php

namespace App\DataTypes;

use Exception;
use Illuminate\Database\Eloquent\Model;

class StatusOrderProductDataType
{
    const PENDING = 'pending';

	const PROCESSED = 'processed';

	const CANCELLED = 'cancelled';

	const OTHER = 'other';

    /**
     * Initialise the Price datatype.
     *
     * @param  mixed  $value
     */
    public function __construct(
        public $value,
    ) {
		// if (!in_array($value, ['pending', 'progress', 'cancelled', 'completed'])) {
			// throw new Exception('Invalid status value.');
		// }
    }

    /**
     * Getter for methods/properties.
     *
     * @param  string  $name
     * @return void
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}();
        }
    }

    /**
     * Cast class as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Format the status value.
     *
     * @return string
     */
    public function label (): string
    {
        return match ($this->value) {
            self::PENDING => 'Pendiente',
            self::PROCESSED => 'Procesado',
            self::CANCELLED => 'Cancelado',
            default => $this->value,
        };
    }

	/**
     *
     * @return string
     */
    public function color (): string
    {
		return match ($this->value) {
			self::PENDING => 'warning',
			self::PROCESSED => 'success',
			self::CANCELLED => 'danger',
			default => 'gray'
		};
	}

}
