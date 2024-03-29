<?php

namespace Okipa\LaravelBootstrapComponents\Button;

use Okipa\LaravelBootstrapComponents\Component;

abstract class Button extends Component
{
    /**
     * The component config key.
     *
     * @property string $view
     */
    protected $configKey;
    /**
     * The button type.
     *
     * @property string $type
     */
    protected $type;
    /**
     * The button url.
     *
     * @property string $url
     */
    protected $url;
    /**
     * The component prepended html.
     *
     * @property string|false $prepend
     */
    protected $prepend;
    /**
     * The component appended html.
     *
     * @property string|false $append
     */
    protected $append;
    /**
     * The button label.
     *
     * @property string|false $label
     */
    protected $label;

    /**
     * Set the button type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the button component url.
     * Will only be effective for « button » typed button components.
     *
     * @param string $url
     *
     * @return $this
     */
    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the button component route.
     * Will only be effective for « button » typed button components.
     *
     * @param string $route
     * @param array $params
     *
     * @return $this
     */
    public function route(string $route, array $params = []): self
    {
        $this->url = route($route, $params);

        return $this;
    }

    /**
     * Prepend html to the button component label.
     *
     * @param string|null $html
     *
     * @return $this
     */
    public function prepend(?string $html): self
    {
        $this->prepend = $html;

        return $this;
    }

    /**
     * Append html to the button component label.
     *
     * @param string|null $html
     *
     * @return $this
     */
    public function append(?string $html): self
    {
        $this->append = $html;

        return $this;
    }

    /**
     * Set the button component label.
     *
     * @param string|null $label
     *
     * @return $this
     */
    public function label(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the values for the view.
     *
     * @return array
     */
    protected function values(): array
    {
        return array_merge(parent::values(), $this->defineValues());
    }

    /**
     * @return array
     */
    protected function defineValues(): array
    {
        return [
            'type'    => $this->type,
            'url'     => $this->url ?: url()->previous(),
            'prepend' => $this->prepend ?? $this->defaultPrepend(),
            'append'  => $this->append ?? $this->defaultAppend(),
            'label'   => $this->label ?? $this->defaultLabel(),
        ];
    }

    /**
     * @return string|null
     */
    protected function defaultPrepend(): ?string
    {
        return config('bootstrap-components.' . $this->configKey . '.prepend');
    }

    /**
     * @return string|null
     */
    protected function defaultAppend(): ?string
    {
        return config('bootstrap-components.' . $this->configKey . '.append');
    }

    /**
     * @return string|null
     */
    public function defaultLabel(): ?string
    {
        $label = config('bootstrap-components.' . $this->configKey . '.label');

        return $label ? 'bootstrap-components::' . $label : null;
    }

    /**
     * Check the component values validity
     *
     * @throws \Exception
     */
    protected function checkValuesValidity(): void
    {
        //
    }
}
