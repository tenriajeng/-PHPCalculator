<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class HistoryController
{
    private $history;

    public function __construct(CommandHistoryManagerInterface $history)
    {
        $this->history = $history;
    }

    public function index(Request $request)
    {
        $data = $this->history->findAll($request->driver);

        $data = collect($data)->map(function ($item) {
            if ($item['command'] == 'Add') {
                $item['input'] = explode(' + ', $item['operation']);
            }
            if ($item['command'] == 'Subtract') {
                $item['input'] = explode(' - ', $item['operation']);
            }
            if ($item['command'] == 'Multiply') {
                $item['input'] = explode(' * ', $item['operation']);
            }
            if ($item['command'] == 'Divide') {
                $item['input'] = explode(' / ', $item['operation']);
            }
            if ($item['command'] == 'Power') {
                $item['input'] = explode(' ^ ', $item['operation']);
            }
            return array(
                'id' => $item['id'],
                'command' => $item['command'],
                'operation' => $item['operation'],
                'input' => $item['input'],
                'result' => $item['result']
            );
        });

        return JsonResponse::create(
            $data,
            200
        );
    }

    public function show($id)
    {
        $data = $this->history->find($id);
        $arr = null;

        if ($data['command'] == 'Add') {
            $arr = explode(' + ', $data['operation']);
        }
        if ($data['command'] == 'Subtract') {
            $arr = explode(' - ', $data['operation']);
        }
        if ($data['command'] == 'Multiply') {
            $arr = explode(' * ', $data['operation']);
        }
        if ($data['command'] == 'Divide') {
            $arr = explode(' / ', $data['operation']);
        }
        if ($data['command'] == 'Power') {
            $arr = explode(' ^ ', $data['operation']);
        }

        $data = array(
            'id' => $data['id'],
            'command' => $data['command'],
            'operation' => $data['operation'],
            'input' => $arr,
            'result' => $data['result']
        );

        return JsonResponse::create($data, 201);
    }

    function multipleexplode($delimiters, $string)
    {
        $phase = str_replace($delimiters, $delimiters[0], $string);
        $processed = explode($delimiters[0], $phase);
        return  $processed;
    }

    public function remove($id)
    {
        $this->history->clear('latest.log', $id);
        $this->history->clear('file', $id);

        return JsonResponse::create(array(), 204);
    }
}
