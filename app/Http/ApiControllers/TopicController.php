<?php

namespace Imojie\Http\ApiControllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Imojie\Models\Topic;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Imojie\Http\Requests\SaveTopicRequest;
use Imojie\Transformers\TopicTransformer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use HyperDown\Parser;

class TopicController extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
        $topics = Topic::all();

        return $this->response()->collection($topics, new TopicTransformer());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(SaveTopicRequest $request)
    {
        $originalContent = trim($request->input('content'));

        $data = array(
            'uid' => Sentinel::getUser()->id,
            'title' => trim($request->input('title')),
            'original_content' => $originalContent,
            'content' => (new Parser)->makeHtml($originalContent),
            'active_at' => time(),
        );

        $topic = Topic::create($data);
        if ($topic && isset($topic->id)) {
            return $this->response()->item($topic, new TopicTransformer());
        } else {
            throw new StoreResourceFailedException('保存失败，请重新尝试');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(SaveTopicRequest $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $user = app('Dingo\Api\Auth\Auth')->user();

        if (Gate::forUser($user)->denies('update-topic', $topic)) {
            throw new AccessDeniedHttpException();
        }

        $originalContent = trim($request->input('content'));

        $data = array(
            'title' => trim($request->input('title')),
            'original_content' => $originalContent,
            'content' => (new Parser)->makeHtml($originalContent),
            'active_at' => time(),
        );

        if ($topic->update($data)) {
            return $this->response()->item($topic, new TopicTransformer());
        } else {
            throw new UpdateResourceFailedException('修改失败，请重新尝试');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        $user = app('Dingo\Api\Auth\Auth')->user();

        if (Gate::forUser($user)->denies('delete-topic', $topic)) {
            throw new AccessDeniedHttpException();
        }

        if ($topic->delete()) {
            return $this->response()->item($topic, new TopicTransformer());
        } else {
            throw new DeleteResourceFailedException('删除失败，请重新尝试');
        }
    }

}
