<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Str;
use App\Models\PacientesEndereco;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\StorePacienteEnderecosRequest;

class PacientesImportacao extends Paciente
{
    protected $table = 'pacientes';
    protected $pathLogFile;
    private $csv = [];

    public function importar($path) {
        $csvFile = fopen(storage_path('app/'. $path), 'r');
        $header = fgetcsv($csvFile);
        $this->csv[] = $header;
        $error = "";

        while (($row = fgetcsv($csvFile)) !== false) {

            $data = $this->tratamentoDados(array_combine($header, $row));
            $pacienteData = $this->getPacienteData($data);
            $pacienteValidator = Validator::make($pacienteData, (new StorePacienteRequest())->rules());
            $possuiEndereco = $this->checaSePossuiEndereco($data);

            if ($possuiEndereco) {
                $pacienteEnderecoData = $this->getPacienteEnderecoData($data);
                $pacienteEnderecoData["paciente_id"] = 1; //apenas para validação, será alterado após criação do paciente
                $enderecoValidator = Validator::make($pacienteEnderecoData, (new StorePacienteEnderecosRequest())->rules());

                if ($enderecoValidator->fails()) {
                    $error = $this->getListaErrors($enderecoValidator->errors());
                }
            }

            if ($pacienteValidator->fails()) {
                $error .= $this->getListaErrors($pacienteValidator->errors());

            } else {

                $paciente = $this->create($pacienteValidator->validated());

                if ($possuiEndereco) {
                    $endereco = $enderecoValidator->validated();
                    $endereco['paciente_id'] = $paciente->id;
                    $pacienteEndereco = PacientesEndereco::create($endereco);
                    $endereco = $pacienteEndereco->save($endereco);
                }
            }

            if ($error != "") {
                $data['erros'] = $error;
                $this->csv[] = $data;
            }
        }

        // se houve erros, gerar aquivo de log
        if ($this->fails()) {
            $this->csv[0][] = "Erro";
            $this->gerarArquivoDeErro();
        }

        // Close the file handle
        fclose($csvFile);

        Storage::delete($path);
    }

    private function gerarArquivoDeErro() : void {

        $fileName = Str::random(40) . '_csv_log.csv';
        $path = 'csv_logs/' . $fileName;

        $csvData = implode("\n", array_map(function ($row) {
            return implode(',', $row);
        }, $this->csv));

        Storage::put($path, $csvData);

        $this->pathLogFile = $fileName;
    }

    public function fails() : bool {
        if (count($this->csv) > 1)
            return true;

        return false;
    }

    public function getFileLog() : String {
        return $this->pathLogFile;
    }

    private function tratamentoDados(array $data) : Array
    {
        $data['data_nascimento'] = $this->tratarDataNascimento($data['data_nascimento']);
        $data['cns'] = (int) trim(str_replace(' ', '', trim($data['cns'])));
        $data['cpf'] = (int) str_replace('-', '', str_replace('.', '', trim($data['cpf'])));

        if (isset($data['cep'])) {
            $data['cep'] = trim(str_replace('-', '', trim($data['cep'])));
        }

        return $data;
    }

    private function checaSePossuiEndereco($data) : Bool
    {
        $fillable = (new PacientesEndereco())->getFillable();
        unset($fillable[0]);

        foreach ($fillable as $field) {

            if ($data[$field] != '') {

                return true;
            }
        }

        return false;
    }

    private function getListaErrors($errors) : String {
        $list = [];
        $all_errors = $errors->all();
        $list = implode(" | ", $all_errors);
        return $list;
    }

    private function getPacienteEnderecoData($data) {
        return array_intersect_key($data, array_flip((new PacientesEndereco())->getFillable()));
    }

    private function getPacienteData($data) {
        return array_intersect_key($data, array_flip((new Paciente())->getFillable()));
    }

    private function tratarDataNascimento($date) {
        $date = DateTime::createFromFormat('d/m/Y', $date)->format('m/d/Y');
        return $date;
    }
}
