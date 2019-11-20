<?php
/**
 * Created by PhpStorm.
 * User: mr_dreek
 * Date: 04.12.18
 * Time: 19:56
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class Request extends FormRequest
{
    protected $trim = true;

    public function input($key = null, $default = null)
    {
        $input = array_merge($this->getInputSource()->all(), $this->query->all());

        // replace input with trimmed input
        $input = $this->getTrimmedInput($input);

        return data_get($input, $key, $default);
    }

    /**
     * Get trimmed input
     *
     * @param  array  $input
     *
     * @return array
     */
    protected function getTrimmedInput(array $input): array
    {
        if ($this->trim) {
            array_walk_recursive($input, static function (&$item, $key) {
                if (is_string($item) && !Str::contains($key, 'password')) {
                    $item = trim($item);
                }
            });
        }

        return $input;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
