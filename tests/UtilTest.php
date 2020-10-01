<?php

/*
 * Copyright 2016 Denys.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use HeitorFig\WSBoletoSantander\Util;

/**
 * Testes unitários para a classe Util
 * 
 * @author Denys Xavier <equipe@tiexpert.net>
 */
class UtilTest extends \PHPUnit_Framework_TestCase {

    /**
     * @author Denys Xavier <equipe@tiexpert.net>
     * @test
     */
    public function umaStringDeDataFormatadaCorretamenteDeveGerarUmObjetoDateTime() {
        $str = date(\HeitorFig\WSBoletoSantander\Config::getInstance()->getGeral("formato_data"));

        $dataEsperada = new \DateTime();
        $dataEsperada->setDate(date("Y"), date("m"), date("d"));

        $resultado = Util::converterParaDateTime($str);

        $this->assertEquals($dataEsperada, $resultado, '', 60);
    }

    /**
     * @author Denys Xavier <equipe@tiexpert.net>
     * @test
     */
    public function seOParametroUsadoAoConverterParaDateTimeForTambemDateTimeEntaoOProprioObjetoDeveSerRetornado() {
        $dataEsperada = new \DateTime("2016-11-28 12:00:00");

        $resultado = Util::converterParaDateTime($dataEsperada);

        $this->assertEquals($dataEsperada, $resultado, '', 60);
    }

    /**
     * @author Denys Xavier <equipe@tiexpert.net>
     * @test
     */
    public function seOParametroUsadoAoConverterParaDateTimeForNuloEntaoOProprioParametroEhRetornado() {
        $this->assertNull(Util::converterParaDateTime(NULL));
    }

    /**
     * @author Denys Xavier <equipe@tiexpert.net>
     * @test
     * @expectedException InvalidArgumentException
     */
    public function seOParametroUsadoAoConverterParaDateTimeNaoForStringOuDateTimeEntaoUmaExcecaoDeveSerLancada() {
        $array = array("2016-11-28");

        Util::converterParaDateTime($array);
    }

    /**
     * @author Denys Xavier <equipe@tiexpert.net>
     * @test
     * @expectedException Exception
     */
    public function umaStringDeDataFormatadaIncorretamenteDeveLancarUmaExcecao() {
        $string = "11#28#2016";

        Util::converterParaDateTime($string);
    }

}
