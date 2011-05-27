<?php

/**
 * Data validation class for Brazil
 *
 * @category   Validate
 * @package    Validate_BR
 * @author     Paulo Freitas <paulofreitas.web@gmail.com>
 * @version    20100404
 * @copyright  2005-2010 Paulo Freitas
 * @license    http://creativecommons.org/licenses/by-sa/3.0
 */
class Validate_BR
{
    /*
     * Credit card flag constants
     */
    const CARD_AMEX       = 1;
    const CARD_DINERS     = 2;
    const CARD_DISCOVER   = 4;
    const CARD_MASTERCARD = 8;
    const CARD_VISA       = 16;
    const CARD_ALL        = 32;

    /**
     * Validates credit card
     *
     * @param   string $cc credit card number to validate
     * @param   int $flag card flag to validate
     * @return  bool TRUE if the number is a valid credit card, FALSE otherwise
     * @access  public
     * @since   20060317
     */
    public static function CC($cc, $flag = Validate_BR::CARD_ALL)
    {
        // Canonicalize input
        $cc = preg_replace('{\D}', '', $cc);

        // Validate choosed flags
        $er = array();

        if ($flag & self::CARD_AMEX) {
            $er[] = '^3[47].{13}$';
        }

        if ($flag & self::CARD_DINERS) {
            $er[] = '^3(0[0-5].{11}|6.{12})$';
        }

        if ($flag & self::CARD_DISCOVER) {
            $er[] = '^6(011.{12}|5.{14})$';
        }

        if ($flag & self::CARD_MASTERCARD) {
            $er[] = '^5[1-5].{14}$';
        }

        if ($flag & self::CARD_VISA) {
            $er[] = '^4.{15}$';
        }

        if (empty($er) || !preg_match('~' . implode('|', $er) . '~', $cc)) {
            return false;
        }

        // Validate digits using a modulus 10 algorithm (aka Luhn)
        for ($sum = 0, $idx = strlen($cc) - 1, $wt = 1; $idx >= 0;
             $wt = ($wt % 2) + 1, --$idx) {
            $sum += (($d = intval($cc[$idx]) * $wt) > 9) ? $d - 9 : $d;
        }

        return (($sum % 10) == 0);
    }

    /**
     * Validates CNH (Carteira Nacional de Habilitação)
     *
     * CNH is the Brazilian driving license.
     *
     * @param   string $cnh CNH number to validate
     * @return  bool TRUE if the number is a valid CNH, FALSE otherwise
     * @access  public
     * @since   20100404
     */
    public static function CNH($cnh)
    {
        // Canonicalize input
        $cnh = sprintf('%011s', preg_replace('{\D}', '', $cnh));

        // Validate length and invalid numbers
        if ((strlen($cnh) != 11) || (intval($cnh) == 0)) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($c = $s1 = $s2 = 0, $p = 9; $c < 9; $c++, $p--) {
            $s1 += intval($cnh[$c]) * $p;
            $s2 += intval($cnh[$c]) * (10 - $p);
        }

        if ($cnh[9] != (($dv1 = $s1 % 11) > 9) ? 0 : $dv1) {
            return false;
        }

        if ($cnh[10] != (((($dv2 = ($s2 % 11) - (($dv1 > 9) ? 2 : 0)) < 0)
                ? $dv2 + 11 : $dv2) > 9) ? 0 : $dv2) {
            return false;
        }

        return true;
    }

    /**
     * Validates CNPJ (Cadastro Nacional da Pessoa Jurídica)
     *
     * CNPJ is the Brazilian corporate taxpayer identification number.
     *
     * @param   string $cnpj CNPJ number to validate
     * @return  bool TRUE if the number is a valid CNPJ, FALSE otherwise
     * @access  public
     * @since   20050619
     */
    public static function CNPJ($cnpj)
    {
        // Canonicalize input
        $cnpj = sprintf('%014s', preg_replace('{\D}', '', $cnpj));

        // Validate length and CNPJ order
        if ((strlen($cnpj) != 14)
                || (intval(substr($cnpj, -4)) == 0)) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 11; $t < 13;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, ($p < 9) ? $p++
                                                                  : $p = 2) {
                $d += $cnpj[$c] * $p;
            }

            if ($cnpj[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates CPF (Cadastro de Pessoas Físicas)
     *
     * CPF is the Brazilian individual taxpayer identification number.
     *
     * @param   string $cpf CPF number to validate
     * @return  bool TRUE if the number is a valid CPF, FALSE otherwise
     * @access  public
     * @since   20050617
     */
    public static function CPF($cpf)
    {
        // Canonicalize input
        $cpf = sprintf('%011s', preg_replace('{\D}', '', $cpf));

        // Validate length and invalid numbers
        if ((strlen($cpf) != 11)
                || ($cpf == '00000000000')
                || ($cpf == '99999999999')) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 8; $t < 10;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, $p++) {
                $d += $cpf[$c] * $p;
            }

            if ($cpf[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates DDD (Discagem Direta a Distância)
     *
     * DDD is the Brazilian phone area code (NPA).
     *
     * @param   string $ddd 2-digit DDD code
     * @return  bool TRUE if the code is a valid DDD, FALSE otherwise
     * @access  public
     * @since   20080719
     */
    public static function DDD($ddd)
    {
        return preg_match('{^([14689][1-9]|2[14]|[23][278]|[357][13-5]|7[79])$}',
            $ddd) != false;
    }

    /**
     * Validates NIS (PIS/PASEP/NIT)
     *
     * PIS/PASEP/NIT is the Brazilian social integration program.
     *
     * @param   string $nis NIS number to validate
     * @return  bool TRUE if the number is a valid NIS, FALSE otherwise
     * @access  public
     * @since   20050620
     */
    public static function NIS($nis)
    {
        // Canonicalize input
        $nis = sprintf('%011s', preg_replace('{\D}', '', $nis));

        // Validate length and invalid numbers
        if ((strlen($nis) != 11)
                || (intval($nis) == 0)) {
            return false;
        }

        // Validate check digit using a modulus 11 algorithm
        for ($d = 0, $p = 2, $c = 9; $c >= 0; $c--, ($p < 9) ? $p++ : $p = 2) {
            $d += $nis[$c] * $p;
        }

        return ($nis[10] == (((10 * $d) % 11) % 10));
    }

    /**
     * Validates TE (Título Eleitoral)
     *
     * Título Eleitoral is the Brazilian voter registration card.
     *
     * @param   string $te TE number to validate
     * @return  bool TRUE if the number is a valid TE, FALSE otherwise
     * @access  public
     * @since   20060315
     */
    public static function TE($te)
    {
        // Canonicalize input and parse UF
        $te = sprintf('%012s', preg_replace('{\D}', '', $te));
        $uf = intval(substr($te, 8, 2));

        // Validate length and invalid UFs
        if ((strlen($te) != 12)
                || ($uf < 1)
                || ($uf > 28)) {
            return false;
        }

        // Validate check digits using a slightly modified modulus 11 algorithm
        foreach (array(7, 8 => 10) as $s => $t) {
            for ($d = 0, $p = 2, $c = $t; $c >= $s; $c--, $p++) {
                $d += $te[$c] * $p;
            }

            if ($te[($s) ? 11 : 10] != ((($d %= 11) < 2) ? (($uf < 3) ? 1 - $d
                                                                      : 0)
                                                         : 11 - $d)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates UF (Unidade Federativa)
     *
     * UF is the Brazilian federal unit.
     *
     * @param   string $uf 2-letter UF code
     * @return  bool TRUE if the code is a valid UF, FALSE otherwise
     * @access  public
     * @since   20050620
     */
    public static function UF($uf)
    {
        return preg_match('{^A[CLMP]|BA|CE|DF|ES|[GT]O|M[AGST]|P[ABEIR]|R[JNORS]'
            . '|S[CEP]$}', $uf) != false;
    }
}