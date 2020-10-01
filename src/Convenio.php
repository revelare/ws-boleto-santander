<?php

/*
 * Copyright 2016 Denys Xavier.
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

namespace HeitorFig\WSBoletoSantander;

/**
 * Classe que representa o convênio usado na confecção do boleto
 *
 * @author Denys Xavier <equipe@tiexpert.net>
 */
class Convenio implements PropriedadesExportaveisParaArrayInterface, PropriedadesImportaveisPorXMLInterface {

    /** property string $codigoBanco Código do banco */
    private $codigoBanco;

    /** property string $codigoConvenio Número do convênio informado pelo banco */
    private $codigoConvenio;

    /** Cria uma nova instância de Convenio.
     * 
     * Se nenhum parâmetro for informado, então, o código do banco e o convênio são carregados a partir da configuração do arquivo config.ini
     * 
     * @param string $codigoBanco Código do banco
     * @param string $codigoConvenio Número do convênio informado pelo banco
     */
    public function __construct($codigoBanco = NULL, $codigoConvenio = NULL) {
        $this->codigoBanco = $codigoBanco;
        $this->codigoConvenio = $codigoConvenio;

        if (is_null($codigoBanco) && is_null($codigoConvenio)) {
            $config = Config::getInstance();
            $this->codigoBanco = $config->getConvenio("banco_padrao");
            $this->codigoConvenio = $config->getConvenio("convenio_padrao");
        }
    }

    /** Obtém o código do banco
     * 
     * @return string
     */
    public function getCodigoBanco() {
        return $this->codigoBanco;
    }

    /** Obtém o número do convênio
     * 
     * @return string
     */
    public function getCodigoConvenio() {
        return $this->codigoConvenio;
    }

    /** Determina o código do banco
     * 
     * @param string $codigoBanco Código do banco
     * @return \HeitorFig\WSBoletoSantander\Convenio
     */
    public function setCodigoBanco($codigoBanco) {
        $this->codigoBanco = $codigoBanco;
        return $this;
    }

    /** Determina o número do convênio
     * 
     * @param string $codigoConvenio
     * @return \HeitorFig\WSBoletoSantander\Convenio
     */
    public function setCodigoConvenio($codigoConvenio) {
        $this->codigoConvenio = $codigoConvenio;
        return $this;
    }

    /** Exporta um array associativo no qual as chaves são as propriedades representadas como no WebService do Santander
     * 
     * @return array
     */
    public function exportarArray() {
        $array["CONVENIO.COD-BANCO"] = $this->codigoBanco;
        $array["CONVENIO.COD-CONVENIO"] = $this->codigoConvenio;

        return $array;
    }

    /** Carrega as propriedades da instância usando a estrutura XML
     * 
     * @param \DOMDocument $xml Estrutura XML legível
     */
    public function carregarPorXML(\DOMDocument $xml) {
        $leitor = new LeitorSimplesXML($xml);

        $this->setCodigoBanco($leitor->getValorNo("codBanco"));
        $this->setCodigoConvenio($leitor->getValorNo("codConv"));
    }

}
