<?php

namespace Instrument\Reports;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Instrument\Instrument;
use Instrument\InteractsWithReport;

abstract class Report
{
    use InteractsWithReport;

    /**
     * The report's model
     */
    public mixed $model;

    /**
     * The report's default name.
     *
     * @var string
     */
    public string $name = '';

    /**
     * Indicates whether the report has money.
     *
     * @var bool
     */
    public bool $hasMoney = false;

    /**
     * The report's year.
     *
     * @var int
     */
    public int $year;

    /**
     * The report's tables.
     *
     * @var array
     */
    public array $tables = [];

    /**
     * The report's dates.
     *
     * @var array
     */
    public array $dates = [];

    /**
     * The report's row names.
     *
     * @var array
     */
    public array $rowNames = [];

    /**
     * The report's row values.
     *
     * @var array
     */
    public array $rowValues = [];

    /**
     * The report's footer totals.
     *
     * @var array
     */
    public array $footerTotals = [];

    /**
     * The report's groups.
     *
     * @var array
     */
    public array $groups = [];

    /**
     * The report's filters.
     *
     * @var array
     */
    public array $filters = [];

    /**
     * Indicates report has been loaded.
     *
     * @var bool
     */
    public bool $loaded = false;

    /**
     * Constructor.
     */
    public function __construct(bool $loadData = true)
    {
        $this->setGroups();

        $this->model = Instrument::reportModel();

        if ($loadData) {
            $this->load();
        }
    }

    /**
     * Sets the report's data.
     *
     * @return void
     */
    abstract public function setData();

    /**
     * Hydrates the report.
     *
     * @return void
     */
    public function load()
    {
        $this->setYear();
        $this->setTables();
        $this->setDates();
        $this->setFilters();
        $this->setRows();
        $this->loadData();

        $this->loaded = true;
    }

    /**
     * Loads the report's data.
     *
     * @return void
     */
    public function loadData()
    {
        $this->setData();
    }

    /**
     * Gets the default name of the report.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get's grand total.
     *
     * @return string
     */
    public function getGrandTotal(): string
    {
        if (! $this->loaded) {
            $this->load();
        }

        if (! empty($this->footerTotals)) {
            $sum = 0;

            foreach ($this->footerTotals as $total) {
                $sum += is_array($total) ? array_sum($total) : $total;
            }

            $total = $this->hasMoney ? Instrument::money($sum) : $sum;
        } else {
            $total = __("N/A");
        }

        return $total;
    }

    /**
     * Sets the report's year.
     *
     * @return void
     */
    public function setYear()
    {
        $this->year = request('year', now()->year);
    }

    /**
     * Sets the report's tables.
     *
     * @return void
     */
    public function setTables()
    {
        $this->tables = [
            'default' => 'default',
        ];
    }

    /**
     * Get's a reports setting by key.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getSetting(string $name, $default = '')
    {
        return $this->model->settings[$name] ?? $default;
    }

    /**
     * Get the report's financial year.
     *
     * @param mixed $year
     * @return \Carbon\CarbonPeriod
     */
    public function getFinancialYear($year = null)
    {
        $start = $this->getFinancialStart($year);

        return CarbonPeriod::create($start, $start->copy()->addYear()->subDay()->endOfDay());
    }

    /**
     * Get the report's financial quarter.
     *
     * @param mixed $year
     * @return \Carbon\CarbonPeriod
     */
    public function getFinancialQuarters($year = null)
    {
        $quarters = [];
        $start = $this->getFinancialStart($year);

        for ($i = 0; $i < 4; $i++) {
            $quarters[] = CarbonPeriod::create($start->copy()->addQuarters($i), $start->copy()->addQuarters($i + 1)->subDay()->endOfDay());
        }

        return $quarters;
    }

    /**
     * Sets the report's dates.
     *
     * @return void
     */
    public function setDates()
    {
        if (! $period = $this->getSetting('period')) {
            return;
        }

        $function = 'sub' . ucfirst(str_replace('ly', '', $period));

        $start = $this->getFinancialStart($this->year)->copy()->$function();

        for ($j = 1; $j <= 12; $j++) {
            switch ($period) {
                case 'yearly':
                    $start->addYear();

                    $j += 11;

                    break;
                case 'quarterly':
                    $start->addQuarter();

                    $j += 2;

                    break;
                default:
                    $start->addMonth();

                    break;
            }

            $date = $this->getFormattedDate($start);

            $this->dates[] = $date;

            foreach ($this->tables as $table) {
                $this->footerTotals[$table][$date] = 0;
            }
        }
    }

    /**
     * Sets filters.
     *
     * @return void
     */
    abstract public function setFilters();

    /**
     * Sets groups.
     *
     * @return void
     */
    abstract public function setGroups();

    /**
     * Sets rows.
     *
     * @return void
     */
    abstract public function setRows();

    /**
     * Sets totals.
     *
     * @param mixed $items
     * @param string $dateField
     * @param bool $checkType
     * @param string $table
     * @param bool $withTax
     * @return void
     */
    public function setTotals($items, string $dateField, bool $checkType = false, string $table = 'default', bool $withTax = true)
    {
        $groupField = $this->getSetting('group') . '_id';

        foreach ($items as $item) {
            // Make groups extensible
            $item = $this->applyGroups($item);

            $date = $this->getFormattedDate(Carbon::parse($item->$dateField));

            if (! isset($item->$groupField)) {
                continue;
            }

            $group = $item->$groupField;

            if (
                ! isset($this->rowValues[$table][$group])
                || ! isset($this->rowValues[$table][$group][$date])
                || ! isset($this->footerTotals[$table][$date])
            ) {
                continue;
            }

            $amount = $item->getAmountConvertedToDefault(false, $withTax);

            $type = ($item->type === 'invoice' || $item->type === 'income') ? 'income' : 'expense';

            if (($checkType == false) || ($type == 'income')) {
                $this->rowValues[$table][$group][$date] += $amount;

                $this->footerTotals[$table][$date] += $amount;
            } else {
                $this->rowValues[$table][$group][$date] -= $amount;

                $this->footerTotals[$table][$date] -= $amount;
            }
        }
    }

    /**
     * Sets the report's arithmetic totals.
     *
     * @param array $items
     * @param string $dateField
     * @param string $operator
     * @param string $table
     * @param string $amountField
     * @return void
     */
    public function setArithmeticTotals(array $items, string $dateField, string $operator = 'add', string $table = 'default', string $amountField = 'amount')
    {
        $groupField = $this->getSetting('group') . '_id';

        $function = $operator . 'ArithmeticAmount';

        foreach ($items as $item) {
            // Make groups extensible
            $item = $this->applyGroups($item);

            $date = $this->getFormattedDate(Carbon::parse($item->$dateField));

            if (! isset($item->$groupField)) {
                continue;
            }

            $group = $item->$groupField;

            if (
                ! isset($this->rowValues[$table][$group])
                || ! isset($this->rowValues[$table][$group][$date])
                || ! isset($this->footerTotals[$table][$date])
            ) {
                continue;
            }

            $amount = isset($item->$amountField) ? $item->$amountField : 1;

            $this->$function($this->rowValues[$table][$group][$date], $amount);
            $this->$function($this->footerTotals[$table][$date], $amount);
        }
    }

    /**
     * Adds an arithmetic amount to a value.
     *
     * @param mixed $current
     * @param mixed $amount
     * @return void
     */
    public function addArithmeticAmount(&$current, $amount)
    {
        $current = $current + $amount;
    }

    /**
     * Subtracts an arithmetic amount to a value.
     *
     * @param mixed $current
     * @param mixed $amount
     * @return void
     */
    public function subArithmeticAmount(&$current, $amount)
    {
        $current = $current - $amount;
    }

    /**
     * Multplies an arithmetic amount to a value.
     *
     * @param mixed $current
     * @param mixed $amount
     * @return void
     */
    public function mulArithmeticAmount(&$current, $amount)
    {
        $current = $current * $amount;
    }

    /**
     * Divides an arithmetic amount to a value.
     *
     * @param mixed $current
     * @param mixed $amount
     * @return void
     */
    public function divArithmeticAmount(&$current, $amount)
    {
        $current = $current / $amount;
    }

    /**
     * Mod an arithmetic amount to a value.
     *
     * @param mixed $current
     * @param mixed $amount
     * @return void
     */
    public function modArithmeticAmount(&$current, $amount)
    {
        $current = $current % $amount;
    }

    /**
     * Expo an arithmetic amount to a value.
     *
     * @param mixed $current
     * @param mixed $amount
     * @return void
     */
    public function expArithmeticAmount(&$current, $amount)
    {
        $current = $current ** $amount;
    }

    /**
     * Apply filters.
     *
     * @return mixed
     */
    abstract public function applyFilters($model, $args = []);

    /**
     * Apply filters.
     *
     * @return mixed
     */
    abstract public function applyGroups($model, $args = []);

    /**
     * Gets the report's formatted date.
     *
     * @param \Carbon\Carbon $date
     * @return null|string
     */
    public function getFormattedDate($date)
    {
        $formattedDate = null;

        switch ($this->getSetting('period')) {
            case 'yearly':
                $financialYear = $this->getFinancialYear($this->year);

                if ($date->greaterThanOrEqualTo($financialYear->getStartDate()) && $date->lessThanOrEqualTo($financialYear->getEndDate())) {
                    if (auth()->user()->currentTeam->reportSettings()->financial_year == 'begins') {
                        $formattedDate = $financialYear->getStartDate()->copy()->format($this->getYearlyDateFormat());
                    } else {
                        $formattedDate = $financialYear->getEndDate()->copy()->format($this->getYearlyDateFormat());
                    }
                }

                break;
            case 'quarterly':
                $quarters = $this->getFinancialQuarters($this->year);

                foreach ($quarters as $quarter) {
                    if ($date->lessThan($quarter->getStartDate()) || $date->greaterThan($quarter->getEndDate())) {
                        continue;
                    }

                    $start = $quarter->getStartDate()->format($this->getQuarterlyDateFormat($this->year));
                    $end = $quarter->getEndDate()->format($this->getQuarterlyDateFormat($this->year));

                    $formattedDate = $start . '-' . $end;
                }

                break;
            default:
                $formattedDate = $date->copy()->format($this->getMonthlyDateFormat($this->year));

                break;
        }

        return $formattedDate;
    }

    /**
     * Gets the report's monthly date format.
     *
     * @param mixed $year
     * @return string
     */
    public function getMonthlyDateFormat($year = null)
    {
        $format = 'M Y';

        return $format;
    }

    /**
     * Gets the report's quaterly date format.
     *
     * @param mixed $year
     * @return string
     */
    public function getQuarterlyDateFormat($year = null)
    {
        $format = 'M Y';

        return $format;
    }

    /**
     * Gets the report's yearly date format.
     *
     * @param mixed $year
     * @return string
     */
    public function getYearlyDateFormat()
    {
        $format = 'Y';

        return $format;
    }

    /**
     * Gets years.
     *
     * @return array
     */
    public function getYears()
    {
        $now = now();

        $years = [];

        $y = $now->addYears(2);
        for ($i = 0; $i < 10; $i++) {
            $years[$y->year] = $y->year;
            $y->subYear();
        }

        return $years;
    }

    /**
     * Applies date filter.
     *
     * @param mixed $model
     * @param array $args
     * @return void
     */
    public function applyDateFilter($model, $args = [])
    {
        $model->monthsOfYear($args['date_field']);
    }

    /**
     * Applies account group.
     *
     * @param mixed $model
     * @return void
     */
    public function applyAccountGroup($model)
    {
        if ($model->getTable() != 'documents') {
            return;
        }

        $filter = (array) request('account_id', []);

        $model->account_id = 0;

        foreach ($model->transactions as $transaction) {
            if (! empty($filter) && ! in_array($transaction->account_id, $filter)) {
                continue;
            }

            $model->account_id = $transaction->account_id;

            break;
        }
    }

    /**
     * Applies customer group.
     *
     * @param mixed $model
     * @param array $args
     * @return void
     */
    public function applyCustomerGroup($model, $args = [])
    {
        foreach (['customer'] as $type) {
            $idField = $type . '_id';

            $model->$idField = $model->contact_id;
        }
    }

    /**
     * Applies vendor group.
     *
     * @param mixed $model
     * @return void
     */
    public function applyVendorGroup($model, $args = [])
    {
        foreach (['vendor'] as $type) {
            $idField = $type . '_id';

            $model->$idField = $model->contact_id;
        }
    }

    /**
     * Set row names and values.
     *
     * @param array $rows
     * @return void
     */
    public function setRowNamesAndValues(array $rows)
    {
        foreach ($this->dates as $date) {
            foreach ($this->tables as $table) {
                foreach ($rows as $id => $name) {
                    $this->rowNames[$table][$id] = $name;
                    $this->rowValues[$table][$id][$date] = 0;
                }
            }
        }
    }
}
