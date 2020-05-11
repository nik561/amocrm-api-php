<?php

namespace AmoCRM\Filters;

use AmoCRM\Filters\Interfaces\HasPagesInterface;
use AmoCRM\Filters\Traits\PagesFilterTrait;

class UnsortedFilter extends BaseEntityFilter implements HasPagesInterface
{
    use PagesFilterTrait;

    /**
     * @var array|null
     */
    private $uids = null;

    /**
     * @var string|array|null
     */
    private $category = null;

    /**
     * @var int|null
     */
    private $pipelineId = null;

    /**
     * @var array
     */
    private $order;

    /**
     * @var array
     */
    private $orderFields = [
        'created_at'
    ];

    /**
     * @return array|null
     */
    public function getUids(): ?array
    {
        return $this->uids;
    }

    /**
     * @param array|null $uids
     * @return UnsortedFilter
     */
    public function setUids(?array $uids): UnsortedFilter
    {
        $this->uids = $uids;

        return $this;
    }

    /**
     * @return array|string|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param array|string|null $category
     * @return UnsortedFilter
     */
    public function setCategory($category)
    {
        $this->category = (array)$category;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPipelineId(): ?int
    {
        return $this->pipelineId;
    }

    /**
     * @param int|null $pipelineId
     * @return UnsortedFilter
     */
    public function setPipelineId(?int $pipelineId): UnsortedFilter
    {
        $this->pipelineId = $pipelineId;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOrder(): ?array
    {
        return $this->order;
    }

    /**
     * @param array $order
     * @return UnsortedFilter
     */
    public function setOrder(array $order): UnsortedFilter
    {
        $orderFieldsFiltered = [];

        foreach ($order as $orderField => $orderDirection) {
            if (in_array($orderField, $this->orderFields)) {
                $orderFieldsFiltered[$orderField] = $orderDirection;
            }
        }

        $this->orderFields = $orderFieldsFiltered;

        $this->order = $orderFieldsFiltered;

        return $this;
    }

    /**
     * @return array
     */
    public function buildFilter(): array
    {
        $filter = [];

        if (!is_null($this->getUids())) {
            $filter['filter']['uid'] = $this->getUids();
        }

        if (!is_null($this->getCategory())) {
            $filter['filter']['category'] = $this->getCategory();
        }

        if (!is_null($this->getPipelineId())) {
            $filter['filter']['pipeline_id'] = $this->getPipelineId();
        }

        if (!is_null($this->getOrder())) {
            $filter['order'] = $this->getOrder();
        }

        $filter = $this->buildPagesFilter($filter);

        return $filter;
    }
}