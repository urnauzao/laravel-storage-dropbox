<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DropboxExampleController extends Controller
{
    private $disk_name = 'dropbox';

    public function storage(): Filesystem
    {
        return Storage::drive($this->disk_name);
    }

    public function list()
    {
        // return $this->storage()->files();
        return $this->storage()->allFiles(); //recursive
    }

    public function listDirectories()
    {
        // return $this->storage()->directories();
        return $this->storage()->allDirectories(); //recursive

    }

    /** exemplo de arquivo inicial */
    public function store()
    {
        $this->storage()->put('inicial.txt', 'tudo começa aqui!');
        return response("arquivo inicial criado!");
    }

    /** exemplo principal */
    public function store1()
    {
        Storage::drive('dropbox')
            ->put('teste.txt', "Dev Tech Tips | " . now()->format('d-m-Y H:i:s'));

        return response()->json(['arquivo teste.txt atualizado']);
    }

    /** exemplo alternativo */
    public function store2()
    {
        Storage::disk('dropbox')
            ->put('teste.store2.txt', "Dev Tech Tips | " . now()->format('d-m-Y H:i:s'));

        return response()->json(['arquivo teste.txt atualizado']);
    }

    /** armazena de forma aleatória */
    public function store3()
    {
        $url_file = "https://laravel.com/img/logotype.min.svg";
        $file = Http::get($url_file);
        $content = $file->body();
        $color_fake = str()->upper(fake()->hexColor());
        $content = str_replace('fill="#FF2D20"', 'fill="' . $color_fake . '"', $content);
        Storage::drive('dropbox')->put("laravel/icons/laravel-icon-{$color_fake}.svg", $content);
        return response('Logo criado com sucesso!');
    }

    /**
     * @laravel-doc
     * O 'get' método pode ser usado para recuperar o conteúdo de um arquivo.
     * O conteúdo bruto da string do arquivo será retornado pelo método.
     * Lembre-se de que todos os caminhos de arquivo devem ser especificados em relação ao local “raiz” do disco:
     */
    public function content()
    {
        $result = $this->storage()->get('inicial.txt');
        return response("Conteúdo: " . $result);
    }

    /**
     * @laravel-doc
     * O 'exists' método pode ser usado para determinar se existe um arquivo no disco:
     */
    public function exists()
    {
        $exists = $this->storage()->exists('teste.store.txt');
        return response($exists ? 'sim, existe' : 'não, não existe');
    }

    /**
     * @laravel-doc
     * O 'missing' método pode ser usado para determinar se um arquivo está faltando no disco:
     */
    public function missing()
    {
        try {
            $missing = $this->storage()->missing('teste.store.txt');
        } catch (\Throwable $th) {
            return response('ERROR ' . $th->getMessage(), 400);
        }
        return response($missing ? 'não existe' : 'existe');
    }

    /**
     * @laravel-doc
     * Os métodos 'prepend' e 'append' permitem escrever no início ou no final de um arquivo:
     */
    public function prepend()
    {
        $prepend = $this->storage()->prepend('prepend.log', "\n " . now()->format('d-m-Y H:i:s'));
        return response($prepend ? 'feito' : 'erro!');
    }

    /**
     * @laravel-doc
     * Os métodos 'prepend' e 'append' permitem escrever no início ou no final de um arquivo:
     */
    public function append()
    {
        $append = $this->storage()->append('append.log', "\n " . now()->format('d-m-Y H:i:s'));
        return response($append ? 'feito' : 'erro!');
    }

    /**
     * @laravel-doc
     * O 'copy' método pode ser usado para copiar um arquivo existente para um novo local no disco:
     */
    public function copy()
    {
        $this->storage()->put('para_copiar.txt', 'me copie');
        $result = $this->storage()->copy('para_copiar.txt', 'copias/' . now()->format('d-m-Y_H-i-s') . '.txt');
        return response($result ? 'copiado' : 'não copiado!');

    }

    /**
     * @laravel-doc
     * O 'move'método pode ser usado para renomear ou mover um arquivo existente para um novo local:
     */
    public function move()
    {
        $this->storage()->put('para_mover.txt', 'me mova');
        $result = $this->storage()->move('para_mover.txt', 'movidos/' . now()->format('d-m-Y_H-i-s') . '.txt');
        return response($result ? 'movido' : 'não movido!');
    }

    /** deletar um ou mais itens armazenados */
    public function delete()
    {
        $result = $this->storage()->delete(['para_copiar.txt', 'teste.store.txt', 'teste.store2.txt']);
        return response($result ? 'deletado' : 'não deletado!');
    }

    /** retorna um download para o usuário */
    public function download()
    {
        $files = $this->storage()->allFiles();
        $file = $files[10];
        $item = $this->storage()->url($file);
        $file = str_replace('/', '_', $file);
        return response()->streamDownload(fn() => $item, $file);
    }

    /**
     * Outros úteis:
     * Storage::makeDirectory($directory);
     * Storage::deleteDirectory($directory);
     */
}
