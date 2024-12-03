<?php

namespace App\Services;

class VatCalculator
{
    public function parseAmount($text)
    {
        return (!empty($text) && strlen($text) > 0) ? floatval($text) : 0;
    }

    public function calculateAmountReceivable($params)
    {
        $amount = $params['amount'] ?? 0;
        $utilitiesAmount = $params['utilitiesAmount'] ?? 0;
        return $amount - $utilitiesAmount;
    }

    public function calculateVatUnit($vatValue)
    {
        return (100 + $vatValue) / 100;
    }

    public function calculateVatAmount($params)
    {
        $amount = $this->parseAmount($params['amountText'] ?? '');
        $tariffAmount = $params['tariffAmount'] ?? 0;
        $utilitiesAmount = $params['utilitiesAmount'] ?? 0;
        $vat = $params['vat'] ?? 0;

        $amountReceivable = $this->calculateAmountReceivable([
            'amount' => $amount,
            'utilitiesAmount' => $utilitiesAmount,
        ]);
        $vatUnit = $this->calculateVatUnit($vat);
        $costOfUnit = $amountReceivable / $vatUnit;

        return $amountReceivable - $costOfUnit;
    }

    public function calculateCostOfUnit($params)
    {
        $amount = $this->parseAmount($params['amountText'] ?? '');
        $utilitiesAmount = $params['utilitiesAmount'] ?? 0;
        $vat = $params['vat'] ?? 0;

        $amountReceivable = $this->calculateAmountReceivable([
            'amount' => $amount,
            'utilitiesAmount' => $utilitiesAmount,
        ]);
        $vatUnit = $this->calculateVatUnit($vat);

        return $amountReceivable / $vatUnit;
    }

    public function calculateTariffAmountPerKWatt($params)
    {
        $amount = $this->parseAmount($params['amountText'] ?? '');
        $tariffAmount = $params['tariffAmount'] ?? 0;
        $utilitiesAmount = $params['utilitiesAmount'] ?? 0;
        $vat = $params['vat'] ?? 0;

        $amountReceivable = $this->calculateAmountReceivable([
            'amount' => $amount,
            'utilitiesAmount' => $utilitiesAmount,
        ]);
        $vatUnit = $this->calculateVatUnit($vat);
        $costOfUnit = $amountReceivable / $vatUnit;

        return $tariffAmount > 0 ? $costOfUnit / $tariffAmount : 0;
    }
}
