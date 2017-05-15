<?php namespace DummyNamespace\Shortcode;

use Edutalk\Plugins\Blocks\Models\Block;
use Edutalk\Plugins\Blocks\Models\Contracts\BlockModelContract;

class BlockRenderer
{
    protected $block;

    protected $attributes;

    /**
     * @param Block $block
     * @param $attributes
     */
    public function handle(BlockModelContract $block, $attributes)
    {
        $this->block = $block;
        $this->attributes = $attributes;

        $happyMethod = '_template_' . studly_case($block->page_template);

        if (method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }

        return $this->defaultTemplate();
    }

    public function defaultTemplate()
    {
        return view('edutalk-theme::front.block-templates.default', [
            'object' => $this->block
        ]);
    }
}
